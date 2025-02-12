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

            // Création du proformat
            $proformat = new Proformats();
            $proformat->client_id = $request->client_id;
            $proformat->reference_proformat = Proformats::generateReference();
            $proformat->date_emission = $request->date_emission;
            $proformat->date_echeance = $request->date_echeance;
            $proformat->status = $request->status;
            $proformat->save();

            Log::info('Proformat créé avec succès', ['proformat_id' => $proformat->id, 'client_id' => $proformat->client_id]);

            // Création du détail du proformat
            $detailProformat = new DetailsProformat();
            $detailProformat->proformat_id = $proformat->id;
            $detailProformat->produit_id = $request->produit_id;
            $detailProformat->tva = $request->tva;
            $detailProformat->save();

            Log::info('Détail de proformat ajouté avec succès', ['proformat_id' => $proformat->id, 'produit_id' => $detailProformat->produit_id]);

            // Validation de la transaction
            DB::commit();

            // Retourner une réponse JSON en cas de succès
            return response()->json([
                'success' => true,
                'message' => 'Proformat ajouté avec succès',

            ], 200);
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();

            Log::error('Erreur lors de la création du proformat', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            // Retourner une réponse JSON en cas d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du proformat',
                'error' => $e->getMessage(),
            ], 500);
        }
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

            // Trouver le proformat ou lever une exception si introuvable
            $proformat = Proformats::findOrFail($proformats);
            $proformat->client_id = $request->client_id;
            $proformat->date_emission = $request->date_emission;
            $proformat->date_echeance = $request->date_echeance;
            $proformat->status = $request->status;
            $proformat->save();

            Log::info('Proformat mis à jour', ['proformat_id' => $proformat->id, 'client_id' => $proformat->client_id]);

            // Trouver le détail du proformat ou lever une exception si introuvable
            $detailProformat = DetailsProformat::where('proformat_id', $proformats)->firstOrFail();
            $detailProformat->produit_id = $request->produit_id;
            $detailProformat->tva = $request->tva;
            $detailProformat->save();

            Log::info('Détail de proformat mis à jour', ['proformat_id' => $proformat->id, 'produit_id' => $detailProformat->produit_id]);

            DB::commit(); // Validation de la transaction

            // Réponse JSON en cas de succès
            return response()->json([
                'success' => true,
                'message' => 'Proformat mis à jour avec succès'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction
            Log::warning('Proformat ou Détail non trouvé', [
                'proformat_id' => $proformats,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Proformat ou Détail de proformat introuvable'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction
            Log::error('Erreur lors de la mise à jour du proformat', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du proformat'
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
