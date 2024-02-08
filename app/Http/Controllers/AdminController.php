<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
     public function index(Request $request) {
        // Afficher les informations administratives, demandes de prêt, montants à rembourser, etc.
    }

    public function showUser(Request $request, $userId) {
        // Afficher les détails d'un utilisateur spécifique (peut être utilisé pour vérifier les informations)
    }
}
