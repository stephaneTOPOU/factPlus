<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use Illuminate\Http\Request;

class TousLesDevisController extends Controller
{
    public function devis()
    {
        $devis = Devis::with(['client', 'detailDevis.produit'])->get();
        return view('devis.devis', compact('devis'));
    }
}
