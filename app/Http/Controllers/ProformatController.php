<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\DetailsProformat;
use App\Models\Produits;
use App\Models\Proformats;
use Exception;
use Illuminate\Http\Request;

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
        $proformats = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($proformats);

        $detailProformats = $request->validate([
            'produit_id' => 'required|integer',
            'quantite' => 'required|integer',
            'prix_unitaire' => 'required|numeric',
            'tva' => 'required|numeric',
        ]);
        //dd($detailProformats);

        try {

            $proformats = new Proformats();
            $proformats->client_id = $request->client_id;
            $proformats->reference_proformat = Proformats::generateReference();
            $proformats->date_emission = $request->date_emission;
            $proformats->date_echeance = $request->date_echeance;
            $proformats->status = $request->status;
            $proformats->save();



            $detailProformats = new DetailsProformat();
            $detailProformats->proformat_id = $proformats->id;
            $detailProformats->produit_id = $request->produit_id;
            $detailProformats->quantite = $request->quantite;
            $detailProformats->prix_unitaire = $request->prix_unitaire;
            $detailProformats->tva = $request->tva;
            $detailProformats->save();

            return redirect()->back()->with('success', 'Proformat Ajouté avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $proformat = $request->validate([
            'client_id' => 'required|integer',
            'date_emission' => 'required|string|date',
            'date_echeance' => 'required|string|date',
            'status' => 'required|string',
        ]);
        //dd($proformat);

        $detailProformats = $request->validate([
            'produit_id' => 'required|integer',
            'quantite' => 'required|integer',
            'prix_unitaire' => 'required|numeric',
            'tva' => 'required|numeric',
        ]);
        //dd($detailProformats);

        try {

            $proformat = Proformats::find($proformats);
            $proformat->client_id = $request->client_id;
            $proformat->date_emission = $request->date_emission;
            $proformat->date_echeance = $request->date_echeance;
            $proformat->status = $request->status;
            $proformat->update();

            $detailProformats = DetailsProformat::where('proformat_id', $proformat->id)->first();

            $detailProformats->proformat_id = $proformat->id;
            $detailProformats->produit_id = $request->produit_id;
            $detailProformats->quantite = $request->quantite;
            $detailProformats->prix_unitaire = $request->prix_unitaire;
            $detailProformats->tva = $request->tva;
            $detailProformats->update();

            return redirect()->back()->with('success', 'Proformat mis à jour avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $proformat = Proformats::find($proformats);
        $proformat->delete();
        return redirect()->back()->with('success', 'Proformat supprimé avec succès');
    }
}
