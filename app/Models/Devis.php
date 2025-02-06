<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $table = 'devis';

    protected $fillable = [
        'client_id',
        'reference_devis',
        'date_emission',
        'date_echeance',
        'total',
        'status',

    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function detailDevis()
    {
        return $this->hasMany(DetailsDevis::class, 'devis_id');
    }

    public static function generateReference()
    {
        $prefix = 'DEV';
        $date = now()->format('Ymd');

        // Récupère la dernière facture pour incrémenter la séquence
        $lastInvoice = self::orderBy('id', 'desc')->first();

        // Détermine le prochain numéro séquentiel
        $nextSequence = $lastInvoice ? ((int)substr($lastInvoice->reference_devis, -4)) + 1 : 1;

        // Retourne la référence formatée
        return sprintf('%s-%s-%04d', $prefix, $date, $nextSequence);
    }
}
