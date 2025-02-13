<?php

namespace App\Http\Controllers;

use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $transactions = Paiements::with(['facture'])
            ->whereHas('facture', function ($query) {
                $query->where('status', 'payée');
            })
            ->get();
        $orders = Factures::with(['client', 'detailsFacture.produit'])->take(7)->get();
        $produits = Produits::select('produits.id', 'produits.nom', DB::raw('SUM(details_factures.quantite) as total_vendu'))
            ->join('details_factures', 'produits.id', '=', 'details_factures.produit_id')
            ->groupBy('produits.id', 'produits.nom')
            ->orderByDesc('total_vendu')
            ->limit(7)
            ->get();
        return view('index', compact('transactions', 'orders'));
    }
}
