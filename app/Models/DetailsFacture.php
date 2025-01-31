<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsFacture extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'sous_total',
        'tva',

    ];

    public function facture()
    {
        return $this->belongsTo(Factures::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produits::class);
    }

}
