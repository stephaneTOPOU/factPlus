<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsDevis extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'sous_total',
        'tva',
        
    ];
}
