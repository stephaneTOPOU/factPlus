<?php

use App\Models\Clients;
use App\Models\Factures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/api/facture/{id}', function ($id) {
//     return Factures::findOrFail($id);
// });

Route::get('/api/client/{id}', function ($id) {
    return Clients::findOrFail($id);
});

Route::get('/api/produit/detail/{id}', function ($id) {
    return Clients::findOrFail($id);
});

