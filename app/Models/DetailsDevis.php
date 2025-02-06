<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsDevis extends Model
{
    use HasFactory;

    protected $table = 'details_devis';

    protected $fillable = [
        'devis_id',
        'produit_id',
        'tva',

    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class, 'devis_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produits::class, 'produit_id');
    }

}
