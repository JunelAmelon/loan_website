<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remboursement extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'montant_take', 'montant_payer', 'montant_restant', 'client_id'];
     public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
