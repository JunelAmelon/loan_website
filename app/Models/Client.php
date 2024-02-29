<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'email', 'password', 'nom', 'prenom', 'adresse', 'rib', 'date_naissance', 'lieu_naissance', 'code_p', 'tel'];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function demande()
{
    return $this->hasOne(Demande::class, 'client_id', 'id');
}
}
