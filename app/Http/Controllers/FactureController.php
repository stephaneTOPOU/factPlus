<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsFacture;
use App\Models\Factures;
use App\Models\Produits;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factures = Factures::with(['client', 'detailsFacture.produit'])->get();
        return view('facture.index', compact('factures'));
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
        return view('facture.add', compact('clients', 'produits'));
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

            // Vérifier si c'est une facture complète ou juste un produit
            if (!empty($validated['produits']) || isset($validated['produit_id'])) {
                // Création de la facture
                $facture = Factures::create([
                    'client_id' => $validated['client_id'],
                    'reference_facture' => Factures::generateReference(),
                    'date_emission' => $validated['date_emission'],
                    'date_echeance' => $validated['date_echeance'],
                    'status' => $validated['status']
                ]);

                Log::info('Facture créée avec succès', ['facture_id' => $facture->id]);

                // Si plusieurs produits sont fournis
                if (!empty($validated['produits'])) {
                    foreach ($validated['produits'] as $produitData) {
                        $this->ajouterProduitAFacture($facture, $produitData);
                    }
                }

                // Si un seul produit est fourni
                if (isset($validated['produit_id'])) {
                    $this->ajouterProduitAFacture($facture, [
                        'produit_id' => $validated['produit_id'],
                        'quantite' => $validated['quantite'],
                        'tva' => $validated['tva']
                    ]);
                }

                // Mise à jour du total de la facture
                $facture->total();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Facture ajoutés avec succès',
                    'facture' => $facture->load('detailsFacture'),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez fournir au moins un produit ou plusieurs produits'
                ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de l\'ajout de la facture/produit', [
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
     * Fonction pour ajouter un produit à une facture
     */
    private function ajouterProduitAFacture($facture, $produitData)
    {
        $produit = Produits::where('id', $produitData['produit_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if ($produit->quantite_stock < $produitData['quantite']) {
            throw new Exception("Stock insuffisant pour le produit : {$produit->nom}");
        }

        DetailsFacture::create([
            'facture_id' => $facture->id,
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
     * @param  \App\Models\Factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function show($factures)
    {
        $facture = Factures::with(['client', 'detailsFacture.produit'])->find($factures);
        return view('facture.show', compact('facture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function edit($factures)
    {
        $facture = Factures::with(['client', 'detailsFacture.produit'])->find($factures);
        $clients = Clients::all();
        $produits = Produits::all();
        return view('facture.edit', compact('facture', 'clients', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factures  $factures
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $factures)
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

            // Vérifier si c'est une facture complète ou juste un produit
            if (!empty($validated['produits']) || isset($validated['produit_id'])) {
                // Trouver la facture
                $facture = Factures::findOrFail($factures);

                // Mise à jour de la facture
                $facture->update([
                    'client_id' => $validated['client_id'],
                    'date_emission' => $validated['date_emission'],
                    'date_echeance' => $validated['date_echeance'],
                    'status' => $validated['status']
                ]);

                Log::info('Facture mise à jour avec succès', ['facture_id' => $facture->id]);

                // Supprimer les anciens produits
                $facture->detailsFacture()->delete();

                // Si plusieurs produits sont fournis
                if (!empty($validated['produits'])) {
                    foreach ($validated['produits'] as $produitData) {
                        $this->ajouterProduitAFacture($facture, $produitData);
                    }
                }

                // Si un seul produit est fourni
                if (isset($validated['produit_id'])) {
                    $this->ajouterProduitAFacture($facture, [
                        'produit_id' => $validated['produit_id'],
                        'quantite' => $validated['quantite'],
                        'tva' => $validated['tva']
                    ]);
                }

                // Mise à jour du total de la facture
                $facture->total();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Facture mise à jour avec succès',
                    'facture' => $facture->load('detailsFacture'),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez fournir au moins un produit ou plusieurs produits'
                ], 400);
            }
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Facture introuvable', [
                'facture_id' => $factures,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Facture introuvable'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour de la facture/produit', [
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
     * @param  \App\Models\Factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function destroy($factures)
    {
        try {
            DB::beginTransaction(); // Démarrer la transaction

            // Trouver la facture ou lever une exception si elle n'existe pas
            $facture = Factures::findOrFail($factures);
            $facture->delete();

            DB::commit(); // Valider la transaction

            Log::info('Facture supprimée avec succès', ['facture_id' => $facture->id]);

            return response()->json(['success' => 'Facture supprimée avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction
            Log::warning('Facture introuvable', [
                'facture_id' => $factures,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Facture introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction
            Log::error('Erreur lors de la suppression de la facture', [
                'error' => $e->getMessage(),
                'facture_id' => $factures
            ]);

            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de la facture'], 500);
        }
    }
}
