<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsDevis;
use App\Models\Devis;
use App\Models\Produits;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DevisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devis = Devis::with(['client', 'detailDevis.produit'])->get();
        return view('devis.index', compact('devis'));
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
        return view('devis.add', compact('clients', 'produits'));
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

            // Vérifier si c'est un devis complet ou juste un produit
            if (!empty($validated['produits']) || isset($validated['produit_id'])) {
                // Création du devis
                $devis = Devis::create([
                    'client_id' => $validated['client_id'],
                    'reference_devis' => Devis::generateReference(),
                    'date_emission' => $validated['date_emission'],
                    'date_echeance' => $validated['date_echeance'],
                    'status' => $validated['status']
                ]);

                Log::info('Devis créé avec succès', ['devis_id' => $devis->id]);

                // Si plusieurs produits sont fournis
                if (!empty($validated['produits'])) {
                    foreach ($validated['produits'] as $produitData) {
                        $this->ajouterProduitADevis($devis, $produitData);
                    }
                }

                // Si un seul produit est fourni
                if (isset($validated['produit_id'])) {
                    $this->ajouterProduitADevis($devis, [
                        'produit_id' => $validated['produit_id'],
                        'quantite' => $validated['quantite'],
                        'tva' => $validated['tva']
                    ]);
                }

                // Mise à jour du total du devis
                $devis->total();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Devis ajoutés avec succès',
                    'devis' => $devis->load('detailDevis'),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez fournir au moins un produit ou plusieurs produits'
                ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de l\'ajout du devis/produit', [
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
     * Fonction pour ajouter un produit à une devis
     */
    private function ajouterProduitADevis($devis, $produitData)
    {
        $produit = Produits::where('id', $produitData['produit_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if ($produit->quantite_stock < $produitData['quantite']) {
            throw new Exception("Stock insuffisant pour le produit : {$produit->nom}");
        }

        DetailsDevis::create([
            'devis_id' => $devis->id,
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
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function show($devis)
    {
        $devis = Devis::with(['client', 'detailDevis.produit'])->find($devis);
        return view('devis.show', compact('devis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function edit($devis)
    {
        $clients = Clients::all();
        $produits = Produits::all();
        $devis = Devis::with(['client', 'detailDevis.produit'])->find($devis);
        return view('devis.edit', compact('devis', 'clients', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $devis)
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

            // Vérifier si c'est un devis complet ou juste un produit
            if (!empty($validated['produits']) || isset($validated['produit_id'])) {
                // Trouver le devis
                $devis = Devis::findOrFail($devis);

                // Mise à jour du devis
                $devis->update([
                    'client_id' => $validated['client_id'],
                    'date_emission' => $validated['date_emission'],
                    'date_echeance' => $validated['date_echeance'],
                    'status' => $validated['status']
                ]);

                Log::info('Devis mis à jour avec succès', ['devis_id' => $devis->id]);

                // Supprimer les anciens produits
                $devis->detailDevis()->delete();

                // Si plusieurs produits sont fournis
                if (!empty($validated['produits'])) {
                    foreach (
                        $validated['produits'] as $produitData
                    ) {
                        $this->ajouterProduitADevis($devis, $produitData);
                    }

                    // Mise à jour du total du devis
                    $devis->total();

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Devis mis à jour avec succès',
                        'devis' => $devis->load('detailDevis'),
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous devez fournir au moins un produit ou plusieurs produits'
                    ], 400);
                }
            }
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Devis introuvable', ['devis_id' => $devis, 'error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Devis introuvable'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour du devis/produit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function destroy($devis)
    {
        try {
            // Démarrer la transaction
            DB::beginTransaction();

            // Trouver le devis à supprimer
            $devi = Devis::findOrFail($devis);

            // Supprimer le devis
            $devi->delete();

            // Commit de la transaction
            DB::commit();

            // Log de la suppression
            Log::info('Devis supprimé', ['devis_id' => $devis]);

            // Réponse JSON en cas de succès
            return response()->json(['success' => true, 'message' => 'Devis supprimé avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction

            // Log en cas d'erreur de modèle
            Log::warning('Devis introuvable', ['devis_id' => $devis, 'error' => $e->getMessage()]);

            // Réponse JSON en cas d'erreur (devis non trouvé)
            return response()->json(['success' => false, 'message' => 'Devis introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction

            // Log en cas d'erreur générale
            Log::error('Erreur lors de la suppression du devis', ['error' => $e->getMessage(), 'devis_id' => $devis]);

            // Réponse JSON en cas d'erreur générale
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la suppression du devis'], 500);
        }
    }
}
