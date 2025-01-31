<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsProformat extends Model
{
    use HasFactory;

    protected $fillable = [
        'proformat_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'sous_total',
        'tva',

    ];

    public function proformat()
    {
        return $this->belongsTo(Proformats::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produits::class);
    }

}
