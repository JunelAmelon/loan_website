<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nom', 'prenom', 'adresse', 'rib', 'date_naissance', 'lieu_naissance', 'user_id'];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
