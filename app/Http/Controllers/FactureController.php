<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsFacture;
use App\Models\Factures;
use App\Models\Produits;
use Exception;
use Illuminate\Http\Request;

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

        $facture = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($facture);

        $detailFacture = $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);
        //dd($detailFacture);

        try {

            $facture = new Factures();
            $facture->client_id = $request->client_id;
            $facture->reference_facture = Factures::generateReference();
            $facture->date_emission = $request->date_emission;
            $facture->date_echeance = $request->date_echeance;
            $facture->status = $request->status;
            $facture->save();



            $detailFacture = new DetailsFacture();
            $detailFacture->facture_id = $facture->id;
            $detailFacture->produit_id = $request->produit_id;
            $detailFacture->tva = $request->tva;
            $detailFacture->save();

            return redirect()->back()->with('success', 'Facture Ajoutée avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $facture = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($facture);

        $detailFacture = $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);
        //dd($detailFacture);

        try {

            $facture = Factures::find($factures);
            $facture->client_id = $request->client_id;
            $facture->date_emission = $request->date_emission;
            $facture->date_echeance = $request->date_echeance;
            $facture->status = $request->status;
            $facture->update();

            $detailFacture = DetailsFacture::where('facture_id', $factures)->first();

            $detailFacture->facture_id = $facture->id;
            $detailFacture->produit_id = $request->produit_id;
            $detailFacture->tva = $request->tva;
            $detailFacture->update();

            return redirect()->back()->with('success', 'Facture mise à jour avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
            $facture = Factures::find($factures);
            $facture->delete();
            return redirect()->back()->with('success', 'Facture supprimée avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
        }
    }
}
