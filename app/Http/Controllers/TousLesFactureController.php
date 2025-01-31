<?php

namespace App\Http\Controllers;

use App\Models\Factures;
use Illuminate\Http\Request;

class TousLesFactureController extends Controller
{
    public function invoice()

    {
        $factures = Factures::with(['client', 'detailsFacture.produit'])->get();
        return view('facture.invoice', compact('factures'));
    }
}
