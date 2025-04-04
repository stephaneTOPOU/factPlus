<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'type_client',
        'entreprise'

    ];

    public function facture()
    {
        return $this->hasMany(Factures::class, 'client_id');
    }

    public function devis()
    {
        return $this->hasMany(Devis::class, 'client_id');
    }

    public function proformat()
    {
        return $this->hasMany(Proformats::class, 'client_id');
    }
}
