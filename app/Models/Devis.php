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
        return $this->belongsTo(Clients::class);
    }

    public function detailDevis()
    {
        return $this->hasMany(DetailsDevis::class, 'devis_id');
    }
}
