<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'facture_id',
        'date_paiement',
        'moyen_paiement',

    ];

    public function facture()
    {
        return $this->belongsTo(Factures::class, 'facture_id');
    }

}
