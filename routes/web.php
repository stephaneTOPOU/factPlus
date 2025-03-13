<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProformatController;
use App\Http\Controllers\TousLesDevisController;
use App\Http\Controllers\TousLesFactureController;
use App\Http\Controllers\TousLesProformatController;
use App\Http\Controllers\UserController;
use App\Models\Clients;
use App\Models\Factures;
use App\Models\Produits;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeController::class)->name('home');


Route::resource('/client', ClientController::class);
Route::resource('/produit', ProduitController::class);
Route::resource('/facture', FactureController::class);
Route::resource('/devis', DevisController::class);
Route::resource('/proformat', ProformatController::class);
Route::resource('/paiement', PaiementController::class);
Route::resource('/user', UserController::class);

Route::get('/toutes-les-facture', [TousLesFactureController::class, 'invoice'])->name('invoice');
Route::get('/tous-les-devis', [TousLesDevisController::class, 'devis'])->name('devis');
Route::get('/tous-les-proformats', [TousLesProformatController::class, 'proformat'])->name('proformat');


Route::get('/check-email', [EmailController::class, 'checkEmail'])->name('check.email');



Route::get('/api/facture/{id}', function ($id) {
    return response()->json(Factures::findOrFail($id));
});

Route::get('/api/client/{id}', function ($id) {
    return response()->json(Clients::findOrFail($id));
});

Route::get('/api/produit/detail/{id}', function ($id) {
    return response()->json(Produits::findOrFail($id));
});

Route::get('/produit/stock/{id}', function ($id) {
    $produit = Produits::find($id);
    return response()->json(['stock' => $produit ? $produit->quantite_stock : 0]);
});
