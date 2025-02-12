<?php

namespace App\Http\Controllers;

use App\Models\Produits;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produits::with(['detailsFacture', 'detailsDevis', 'detailsProformat'])->get();
        return view('produit.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produit.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des champs directement sur la requête
        $request->validate([
            'categorie' => 'required|string',
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix_unitaire' => 'required|numeric',
            'quantite_stock' => 'required|integer',
        ]);

        Log::info('Requête reçue pour création de produit', $request->all());

        try {
            DB::beginTransaction();

            $produit = new Produits();
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->prix_unitaire = $request->prix_unitaire;
            $produit->quantite_stock = $request->quantite_stock;
            $produit->categorie = $request->categorie;

            $produit->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Produit enregistré avec succès !'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur d\'enregistrement du produit', [
                'erreur' => $e->getMessage(),
                'données' => $request->all()
            ]);

            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produits  $produits
     * @return \Illuminate\Http\Response
     */
    public function show(Produits $produits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produits  $produits
     * @return \Illuminate\Http\Response
     */
    public function edit($produits)
    {
        //$produit = Produits::find($produits);
        $produit = Produits::with(['detailsFacture', 'detailsDevis', 'detailsProformat'])->find($produits);
        return view('produit.edit', compact('produit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produits  $produits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $produits)
    {
        // Validation des données
        $request->validate([
            'categorie' => 'required|string',
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix_unitaire' => 'required|numeric',
            'quantite_stock' => 'required|integer',
        ]);

        Log::info('Requête reçue pour mise à jour du produit', ['id' => $produits, 'données' => $request->all()]);

        try {
            DB::beginTransaction();

            // Recherche du produit
            $produit = Produits::findOrFail($produits);

            if (!$produit) {
                return response()->json(['success' => false, 'message' => 'Produit non trouvé'], 404);
            }

            // Mise à jour des champs
            $produit->categorie = $request->categorie;
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->prix_unitaire = $request->prix_unitaire;
            $produit->quantite_stock = $request->quantite_stock;

            $produit->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Produit mis à jour avec succès !'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour du produit', [
                'erreur' => $e->getMessage(),
                'id' => $produits,
                'données' => $request->all()
            ]);

            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produits  $produits
     * @return \Illuminate\Http\Response
     */
    public function destroy($produits)
    {
        try {
            DB::beginTransaction(); // Début de la transaction

            $produit = Produits::findOrFail($produits); // Trouver le produit ou lever une exception

            $produit->delete();

            DB::commit(); // Valider la transaction

            Log::info('Produit supprimé avec succès', ['id' => $produits]);

            return response()->json(['success' => true, 'message' => 'Produit supprimé avec succès !'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            Log::warning('Tentative de suppression d\'un produit introuvable', ['id' => $produits]);

            return response()->json(['success' => false, 'message' => 'Produit introuvable'], 404);
        } catch (Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            Log::error('Erreur lors de la suppression du produit', [
                'erreur' => $e->getMessage(),
                'id' => $produits
            ]);

            return response()->json(['success' => false, 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
}
