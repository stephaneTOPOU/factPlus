<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;

    protected $table = 'produits';

    protected $fillable = [
        'nom',
        'description',
        'prix_unitaire',
        'quantite_stock',
        'categorie',

    ];

    public function detailsFacture()
    {
        return $this->hasMany(DetailsFacture::class, 'produit_id');
    }

    public function detailsDevis()
    {
        return $this->hasMany(DetailsDevis::class, 'produit_id');
    }

    public function detailsProformat()
    {
        return $this->hasMany(DetailsProformat::class, 'produit_id');
    }

}
