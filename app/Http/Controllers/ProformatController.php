<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsProformat;
use App\Models\Produits;
use App\Models\Proformats;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProformatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proformats = Proformats::with(['client', 'detailProformat.produit'])->get();
        return view('proformat.index', compact('proformats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Clients::all();
        $produits = Produits::all();
        return view('proformat.add', compact('clients', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'date_emission' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_emission',
            'status' => 'required|string|in:en attente,payée,annulée',

            // Option 1 : Enregistrement de plusieurs produits
            'produits' => 'nullable|array',
            'produits.*.produit_id' => 'required_with:produits|integer|exists:produits,id',
            'produits.*.quantite' => 'required_with:produits|integer|min:1',
            'produits.*.tva' => 'required_with:produits|numeric|min:0',

            // Option 2 : Enregistrement d'un seul produit
            'produit_id' => 'nullable|integer|exists:produits,id',
            'quantite' => 'nullable|integer|min:1',
            'tva' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            // Vérifier si c'est un proformat complet ou juste un produit
            if (!empty($validated['produits']) || isset($validated['produit_id'])) {
                // Création du proformat
                $proformat = Proformats::create([
                    'client_id' => $validated['client_id'],
                    'reference_proformat' => Proformats::generateReference(),
                    'date_emission' => $validated['date_emission'],
                    'date_echeance' => $validated['date_echeance'],
                    'status' => $validated['status']
                ]);

                Log::info('Proformat créé avec succès', ['proformat_id' => $proformat->id]);

                // Si plusieurs produits sont fournis
                if (!empty($validated['produits'])) {
                    foreach ($validated['produits'] as $produitData) {
                        $this->ajouterProduitAProformat($proformat, $produitData);
                    }
                }

                // Si un seul produit est fourni
                if (isset($validated['produit_id'])) {
                    $this->ajouterProduitAProformat($proformat, [
                        'produit_id' => $validated['produit_id'],
                        'quantite' => $validated['quantite'],
                        'tva' => $validated['tva']
                    ]);
                }

                // Mise à jour du total du proformat
                $proformat->total();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Proformat ajouté avec succès',
                    'proformat' => $proformat->load('detailProformat'),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez fournir au moins un produit ou plusieurs produits'
                ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de l\'ajout du proformat/produit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fonction pour ajouter un produit à une proformat
     */
    private function ajouterProduitAProformat($proformat, $produitData)
    {
        $produit = Produits::where('id', $produitData['produit_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if ($produit->quantite_stock < $produitData['quantite']) {
            throw new Exception("Stock insuffisant pour le produit : {$produit->nom}");
        }

        DetailsProformat::create([
            'proformat_id' => $proformat->id,
            'produit_id' => $produitData['produit_id'],
            'quantite' => $produitData['quantite'],
            'tva' => $produitData['tva'],
        ]);

        // Mise à jour du stock
        $produit->decrement('quantite_stock', $produitData['quantite']);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proformats  $proformats
     * @return \Illuminate\Http\Response
     */
    public function show($proformats)
    {
        $proformat = Proformats::with(['client', 'detailProformat.produit'])->find($proformats);
        return view('proformat.show', compact('proformat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proformats  $proformats
     * @return \Illuminate\Http\Response
     */
    public function edit($proformats)
    {
        $clients = Clients::all();
        $produits = Produits::all();
        $proformat = Proformats::with(['client', 'detailProformat.produit'])->find($proformats);
        return view('proformat.edit', compact('proformat', 'clients', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proformats  $proformats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $proformats)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'date_emission' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_emission',
            'status' => 'required|string|in:en attente,payée,annulée',

            // Option 1 : Enregistrement de plusieurs produits
            'produits' => 'nullable|array',
            'produits.*.produit_id' => 'required_with:produits|integer|exists:produits,id',
            'produits.*.quantite' => 'required_with:produits|integer|min:1',
            'produits.*.tva' => 'required_with:produits|numeric|min:0',

            // Option 2 : Enregistrement d'un seul produit
            'produit_id' => 'nullable|integer|exists:produits,id',
            'quantite' => 'nullable|integer|min:1',
            'tva' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            // Trouver le proformat ou lever une exception si introuvable
            $proformat = Proformats::findOrFail($proformats);

            // Mise à jour des informations du proformat
            $proformat->update([
                'client_id' => $validated['client_id'],
                'date_emission' => $validated['date_emission'],
                'date_echeance' => $validated['date_echeance'],
                'status' => $validated['status']
            ]);

            // Supprimer les anciens détails du proformat
            $proformat->detailProformat()->delete();

            // Si plusieurs produits sont fournis
            if (!empty($validated['produits'])) {
                foreach ($validated['produits'] as $produitData) {
                    $this->ajouterProduitAProformat($proformat, $produitData);
                }
            }

            // Si un seul produit est fourni
            if (isset($validated['produit_id'])) {
                $this->ajouterProduitAProformat($proformat, [
                    'produit_id' => $validated['produit_id'],
                    'quantite' => $validated['quantite'],
                    'tva' => $validated['tva']
                ]);
            }

            // Mise à jour du total du proformat
            $proformat->total();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Proformat mis à jour avec succès',
                'proformat' => $proformat->load('detailProformat'),
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Proformat introuvable pour mise à jour', [
                'proformat_id' => $proformats,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Proformat non trouvé'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour du proformat', [
                'error' => $e->getMessage(),
                'proformat_id' => $proformats
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du proformat'
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proformats  $proformats
     * @return \Illuminate\Http\Response
     */
    public function destroy($proformats)
    {
        try {
            DB::beginTransaction(); // Démarrer la transaction

            // Trouver le proformat ou lever une exception si introuvable
            $proformat = Proformats::findOrFail($proformats);

            // Supprimer le proformat
            $proformat->delete();

            DB::commit(); // Validation de la transaction

            return response()->json([
                'success' => true,
                'message' => 'Proformat et ses détails supprimés avec succès'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction
            Log::warning('Proformat introuvable pour suppression', [
                'proformat_id' => $proformats,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Proformat non trouvé'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction
            Log::error('Erreur lors de la suppression du proformat', [
                'error' => $e->getMessage(),
                'proformat_id' => $proformats
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du proformat'
            ], 500);
        }
    }
}
