<?php

namespace App\Http\Controllers;

use App\Models\Paiements;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $transactions = Paiements::with(['facture'])
            ->whereHas('facture', function ($query) {
                $query->where('status', 'payée');
            })
            ->get();

        return view('index', compact('transactions'));
    }
}
