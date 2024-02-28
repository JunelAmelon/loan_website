<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'projet', 'description', 'montant_voulu', 'montant_restant', 'duree_remboursement', 'payement_months', 'statut', 'client_id'];
     public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
