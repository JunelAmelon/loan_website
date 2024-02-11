<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'email', 'password', 'nom', 'prenom', 'adresse', 'rib', 'date_naissance', 'lieu_naissance'];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
