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
        'status',

    ];


    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function detailsFacture()
    {
        return $this->hasMany(DetailsFacture::class, 'facture_id');
    }

    public static function generateReference()
    {
        $prefix = 'FACT';
        $date = now()->format('Ymd');

        // Récupère la dernière facture pour incrémenter la séquence
        $lastInvoice = self::orderBy('id', 'desc')->first();

        // Détermine le prochain numéro séquentiel
        $nextSequence = $lastInvoice ? ((int)substr($lastInvoice->reference_facture, -4)) + 1 : 1;

        // Retourne la référence formatée
        return sprintf('%s-%s-%04d', $prefix, $date, $nextSequence);
    }


    public function calculMontant()
    {
        return $this->detailsFacture->sum(function ($detail) {
            $montantHT = $detail->quantite * $detail->prix_unitaire;
            return $montantHT + ($montantHT * $detail->tva / 100);
        });
    }
}
