<?php

namespace App\Http\Controllers;

use App\Models\Proformats;
use Illuminate\Http\Request;

class TousLesProformatController extends Controller
{
    public function proformat()
    {
        $proformats = Proformats::with(['client', 'detailProformat.produit'])->get();
        return view('proformat.proformat', compact('proformats'));
    }
}
