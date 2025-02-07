<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsDevis;
use App\Models\Devis;
use App\Models\Produits;
use Exception;
use Illuminate\Http\Request;

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
        $devis = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($devis);

        $detailDevis = $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);
        //dd($detailDevis);

        try {

            $devis = new Devis();
            $devis->client_id = $request->client_id;
            $devis->reference_devis = Devis::generateReference();
            $devis->date_emission = $request->date_emission;
            $devis->date_echeance = $request->date_echeance;
            $devis->status = $request->status;
            $devis->save();

            $detailDevis = new DetailsDevis();
            $detailDevis->devis_id = $devis->id;
            $detailDevis->produit_id = $request->produit_id;
            $detailDevis->tva = $request->tva;
            $detailDevis->save();

            return redirect()->back()->with('success', 'Devis Ajoutée avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $devi = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($devi);

        $detail = $request->validate([
            'produit_id' => 'required|integer',
            'tva' => 'required|numeric',
        ]);
        //dd($detail);

        try {

            $devi = Devis::find($devis);
            $devi->client_id = $request->client_id;
            $devi->date_emission = $request->date_emission;
            $devi->date_echeance = $request->date_echeance;
            $devi->status = $request->status;
            $devi->update();

            $detail = DetailsDevis::where('devis_id', $devi->id)->first();

            $detail->devis_id = $devi->id;
            $detail->produit_id = $request->produit_id;
            $detail->tva = $request->tva;
            $detail->update();

            return redirect()->back()->with('success', 'Devis mise à jour avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $devis = Devis::find($devis);
        $devis->delete();
        return redirect()->back()->with('success', 'Devis supprimée avec succès');
    }
}
