<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
     protected $fillable = ['id', 'nom', 'prenom', 'user_id'];
      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
