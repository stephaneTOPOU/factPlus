<?php

namespace App\Http\Controllers;

use App\Models\Factures;
use App\Models\Paiements;
use Exception;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paiements = Paiements::all();
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
        $paiements = $request->validate([
            'facture_id' => 'required|integer',
            'moyen_paiement' => 'required|string',
            'date_paiement' => 'required|string|date',
        ]);
        //dd($paiements);

        try {
            Paiements::create($paiements);


            $staus = Factures::where('id', $request->facture_id)->first();
            $staus->update([
                'status' => 'payée',
            ]);
            

            return redirect()->back()->with('success', 'PAiement Ajouté avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
    public function edit(Paiements $paiements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paiements $paiements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paiements  $paiements
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paiements $paiements)
    {
        //
    }
}
