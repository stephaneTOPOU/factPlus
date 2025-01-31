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
        'date_creation',

    ];

    public function DetailsFacture()
    {
        return $this->hasMany(DetailsFacture::class, 'facture_id');
    }

    public function DetailsDevis()
    {
        return $this->hasMany(DetailsDevis::class, 'devis_id');
    }

    public function DetailsProformat()
    {
        return $this->hasMany(DetailsProformat::class, 'proformat_id');
    }

}
