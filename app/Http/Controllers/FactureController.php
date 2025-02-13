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
        // Validation des données directement dans la requête
        $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);

        $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);

        try {
            // Démarrer la transaction
            DB::beginTransaction();

            // Création de la facture
            $facture = new Factures();
            $facture->client_id = $request->client_id;
            $facture->reference_facture = Factures::generateReference();
            $facture->date_emission = $request->date_emission;
            $facture->date_echeance = $request->date_echeance;
            $facture->status = $request->status;
            $facture->save();

            Log::info('Facture créée avec succès', ['facture_id' => $facture->id, 'client_id' => $facture->client_id]);

            // Création du détail de la facture
            $detailFacture = new DetailsFacture();
            $detailFacture->facture_id = $facture->id;
            $detailFacture->produit_id = $request->produit_id;
            $detailFacture->quantite = $request->quantite;
            $detailFacture->tva = $request->tva;
            $detailFacture->save();

            Log::info('Détail de facture ajouté avec succès', ['facture_id' => $facture->id, 'produit_id' => $detailFacture->produit_id]);

            // Validation de la transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Facture ajoutée avec succès'], 200);
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();

            Log::error('Erreur lors de la création de la facture', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()  // Vous pouvez aussi loguer les données de la requête pour un meilleur suivi
            ]);

            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'ajout de la facture : ' . $e->getMessage()], 500);
        }
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
        // Validation des données directement dans la requête
        $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);

        $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction(); // Démarrer la transaction

            // Trouver la facture ou lever une exception si elle n'existe pas
            $facture = Factures::findOrFail($factures);
            $facture->client_id = $request->client_id;
            $facture->date_emission = $request->date_emission;
            $facture->date_echeance = $request->date_echeance;
            $facture->status = $request->status;
            $facture->save();

            Log::info('Facture mise à jour', ['facture_id' => $facture->id, 'client_id' => $facture->client_id]);

            // Trouver le détail de la facture ou lever une exception si introuvable
            $detailFacture = DetailsFacture::where('facture_id', $factures)->firstOrFail();
            $detailFacture->produit_id = $request->produit_id;
            $detailFacture->quantite = $request->quantite;
            $detailFacture->tva = $request->tva;
            $detailFacture->save();

            Log::info('Détail de facture mis à jour', ['facture_id' => $facture->id, 'produit_id' => $detailFacture->produit_id]);

            DB::commit(); // Validation de la transaction

            return response()->json(['success' => true, 'message' => 'Facture mise à jour avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction
            Log::warning('Facture ou Détail non trouvé', [
                'facture_id' => $factures,
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false, 'message' => 'Facture ou Détail de facture introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction
            Log::error('Erreur lors de la mise à jour de la facture', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la mise à jour de la facture'], 500);
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
