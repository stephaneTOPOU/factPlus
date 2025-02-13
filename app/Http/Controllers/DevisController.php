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

            // Création du devis
            $devis = new Devis();
            $devis->client_id = $request->client_id;
            $devis->reference_devis = Devis::generateReference();
            $devis->date_emission = $request->date_emission;
            $devis->date_echeance = $request->date_echeance;
            $devis->status = $request->status;
            $devis->save();

            Log::info('Devis créé avec succès', ['devis_id' => $devis->id, 'client_id' => $devis->client_id]);

            // Création du détail de devis
            $detailDevis = new DetailsDevis();
            $detailDevis->devis_id = $devis->id;
            $detailDevis->produit_id = $request->produit_id;
            $detailDevis->quantite = $request->quantite;
            $detailDevis->tva = $request->tva;
            $detailDevis->save();

            Log::info('Détail de devis ajouté avec succès', ['devis_id' => $devis->id, 'produit_id' => $detailDevis->produit_id]);

            // Validation de la transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Devis ajouté avec succès'], 201);
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();

            Log::error('Erreur lors de la création du devis', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'ajout du devis'], 500);
        }
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

            // Trouver le devis à mettre à jour
            $devi = Devis::findOrFail($devis);
            $devi->client_id = $request->client_id;
            $devi->date_emission = $request->date_emission;
            $devi->date_echeance = $request->date_echeance;
            $devi->status = $request->status;
            $devi->save();

            Log::info('Devis mis à jour', ['devis_id' => $devi->id, 'client_id' => $devi->client_id]);

            // Trouver le détail du devis
            $detail = DetailsDevis::where('devis_id', $devi->id)->firstOrFail();
            $detail->produit_id = $request->produit_id;
            $detail->quantite = $request->quantite;
            $detail->tva = $request->tva;
            $detail->save();

            Log::info('Détail de devis mis à jour', ['devis_id' => $devi->id, 'produit_id' => $detail->produit_id]);

            DB::commit(); // Validation de la transaction

            return response()->json(['success' => true, 'message' => 'Devis mis à jour avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction
            Log::warning('Devis ou Détail non trouvé', ['devis_id' => $devis, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Devis ou Détail de devis introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction
            Log::error('Erreur lors de la mise à jour du devis', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la mise à jour du devis'], 500);
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
