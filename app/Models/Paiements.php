<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'montant',
        'date_paiement',
        'moyen_paiement',

    ];

    public function Factures()
    {
        return $this->belongsTo(Factures::class);
    }
    
}
