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


    public function detailFacture()
    {
        return $this->hasMany(DetailsFacture::class, 'facture_id');
    }


}
