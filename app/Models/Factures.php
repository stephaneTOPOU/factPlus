<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    use HasFactory;

    protected $table = 'factures';

    protected $fillable = [
        'client_id',
        'reference_facture',
        'date_emission',
        'date_echeance',
        'total',
        'status',

    ];


    public function client()
    {
        return $this->belongsTo(Clients::class);
    }


    public function DetailsFacture()
    {
        return $this->hasMany(DetailsFacture::class, 'facture_id');
    }


    public static function generateReference()
    {
        $prefix = 'FACT';
        $date = now()->format('Ymd');

        // Compte le nombre de factures créées aujourd'hui
        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        // Format avec quatre chiffres pour la séquence
        return sprintf('%s-%s-%04d', $prefix, $date, $countToday);
    }

    public function calculMontant()
    {
        return $this->detailsFacture->sum(function ($detail) {
            return ($detail->quantite * $detail->prix_unitaire) + $detail->tva;
        });
    }
    
}
