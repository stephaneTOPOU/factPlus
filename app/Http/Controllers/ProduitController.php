<?php

namespace App\Http\Controllers;

use App\Models\Produits;
use Exception;
use Illuminate\Http\Request;

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
        $data = $request->validate([
            'categorie' => 'required|string',
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix_unitaire' => 'required|string',
            'quantite_stock' => 'required|string',

        ]);

        try {
            $data = new Produits();

            $data->nom = $request->nom;
            $data->description = $request->description;
            $data->prix_unitaire = $request->prix_unitaire;
            $data->quantite_stock = $request->quantite_stock;
            $data->categorie = $request->categorie;

            $data->save();
            return redirect()->back()->with('success', 'Produit Ajouté avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $data = $request->validate([
            'categorie' => 'required|string',
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix_unitaire' => 'required|string',
            'quantite_stock' => 'required|string',

        ]);

        try {
            $data = Produits::find($produits);

            $data->categorie = $request->categorie;
            $data->nom = $request->nom;
            $data->description = $request->description;
            $data->prix_unitaire = $request->prix_unitaire;
            $data->quantite_stock = $request->quantite_stock;

            $data->update();
            return redirect()->back()->with('success', 'Produit mis à jour avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $produit = Produits::find($produits);
        try {
            $produit->delete();
            return response()->json(['success' => 'Produit supprimé avec succès !']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue'], 500);
        }
    }
}
