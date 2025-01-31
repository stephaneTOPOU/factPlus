<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProformatController;
use App\Http\Controllers\TousLesFactureController;
use App\Http\Controllers\UserController;
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
