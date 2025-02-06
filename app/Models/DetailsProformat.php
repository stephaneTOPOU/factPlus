<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsProformat extends Model
{
    use HasFactory;

    protected $table = 'details_proformat';

    protected $fillable = [
        'proformat_id',
        'produit_id',
        'tva',

    ];

    public function proformat()
    {
        return $this->belongsTo(Proformats::class, 'proformat_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produits::class, 'produit_id');
    }

}
