<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proformats extends Model
{
    use HasFactory;

    protected $table = 'proformats';

    protected $fillable = [
        'client_id',
        'reference_proformat',
        'date_emission',
        'date_echeance',
        'total',
        'status',

    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function detailProformat()
    {
        return $this->hasMany(DetailsProformat::class, 'proformat_id');
    }

    public static function generateReference()
    {
        $prefix = 'PROF';
        $date = now()->format('Ymd');

        // Récupère la dernière facture pour incrémenter la séquence
        $lastInvoice = self::orderBy('id', 'desc')->first();

        // Détermine le prochain numéro séquentiel
        $nextSequence = $lastInvoice ? ((int)substr($lastInvoice->reference_proformat, -4)) + 1 : 1;

        // Retourne la référence formatée
        return sprintf('%s-%s-%04d', $prefix, $date, $nextSequence);
    }
}
