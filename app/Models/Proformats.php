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
        return $this->belongsTo(Clients::class);
    }

    public function detailProformat()
    {
        return $this->hasMany(DetailsProformat::class, 'proformat_id');
    }

    public static function generateReference()
    {
        $prefix = 'PROF';
        $date = now()->format('Ymd');

        // Compte le nombre de factures créées aujourd'hui
        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        // Format avec quatre chiffres pour la séquence
        return sprintf('%s-%s-%04d', $prefix, $date, $countToday);
    }

}
