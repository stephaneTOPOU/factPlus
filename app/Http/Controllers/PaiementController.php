<?php

namespace App\Http\Controllers;

use App\Models\Factures;
use App\Models\Paiements;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paiements = Paiements::with(['facture'])->get();
        return view('paiement.index', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $factures = Factures::all();
        return view('paiement.add', compact('factures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'facture_id' => 'required|integer',
            'moyen_paiement' => 'required|string',
            'date_paiement' => 'required|string|date',
        ]);

        try {
            // Démarrer la transaction
            DB::beginTransaction();

            // Créer un nouveau paiement directement à partir des données de la requête
            Paiements::create([
                'facture_id' => $request->facture_id,
                'moyen_paiement' => $request->moyen_paiement,
                'date_paiement' => $request->date_paiement,
            ]);

            // Mettre à jour le statut de la facture
            $facture = Factures::where('id', $request->facture_id)->firstOrFail();
            $facture->update([
                'status' => 'payée',
            ]);

            // Commit de la transaction
            DB::commit();

            // Log du succès
            Log::info('Paiement ajouté avec succès', ['facture_id' => $request->facture_id]);

            // Retourner une réponse JSON de succès
            return response()->json(['success' => true, 'message' => 'Paiement ajouté avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction en cas de facture introuvable

            // Log en cas de facture introuvable
            Log::warning('Facture introuvable', ['facture_id' => $request->facture_id, 'error' => $e->getMessage()]);

            // Retourner une réponse JSON d'erreur
            return response()->json(['success' => false, 'message' => 'Facture introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur

            // Log en cas d'erreur générale
            Log::error('Erreur lors de l\'ajout du paiement', ['error' => $e->getMessage(), 'request_data' => $request->all()]);

            // Retourner une réponse JSON d'erreur
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'ajout du paiement'], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function show(Paiements $paiements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function edit($paiements)
    {
        $paiement = Paiements::with(['facture'])->find($paiements);
        $factures = Factures::all();
        return view('paiement.edit', compact('paiement', 'factures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paiements)
    {
        // Validation des données directement dans la requête
        $request->validate([
            'facture_id' => 'required|integer',
            'moyen_paiement' => 'required|string',
            'date_paiement' => 'required|string|date',
        ]);

        try {
            DB::beginTransaction(); // Démarrer la transaction

            // Récupérer le paiement correspondant ou lever une exception si introuvable
            $data = Paiements::findOrFail($paiements);

            // Mettre à jour le paiement avec les données de la requête
            $data->update([
                'facture_id' => $request->facture_id,
                'moyen_paiement' => $request->moyen_paiement,
                'date_paiement' => $request->date_paiement,
            ]);

            Log::info('Paiement mis à jour', ['paiement_id' => $data->id, 'facture_id' => $request->facture_id]);

            // Mettre à jour le statut de la facture
            $staus = Factures::where('id', $request->facture_id)->first();
            $staus->update([
                'status' => 'payée',
            ]);

            Log::info('Facture mise à jour', ['facture_id' => $staus->id, 'status' => 'payée']);

            DB::commit(); // Validation de la transaction

            return response()->json([
                'success' => true,
                'message' => 'Paiement mis à jour avec succès'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            Log::error('Erreur lors de la mise à jour du paiement ou de la facture', [
                'error' => $e->getMessage(),
                'paiement_id' => $paiements,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Paiement ou facture introuvable'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur générique
            Log::error('Erreur lors de la mise à jour du paiement', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du paiement'
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function destroy($paiements)
    {
        try {
            DB::beginTransaction(); // Démarrer la transaction

            // Trouver le paiement correspondant ou lever une exception si introuvable
            $paiement = Paiements::findOrFail($paiements);

            // Supprimer le paiement
            $paiement->delete();

            Log::info('Paiement supprimé avec succès', ['paiement_id' => $paiements]);

            DB::commit(); // Valider la transaction

            return response()->json([
                'success' => true,
                'message' => 'Paiement supprimé avec succès'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            Log::error('Erreur lors de la suppression du paiement', [
                'error' => $e->getMessage(),
                'paiement_id' => $paiements,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Paiement introuvable'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur générique
            Log::error('Erreur lors de la suppression du paiement', [
                'error' => $e->getMessage(),
                'paiement_id' => $paiements,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du paiement'
            ], 500);
        }
    }
}
