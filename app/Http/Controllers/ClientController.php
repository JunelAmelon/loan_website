<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Remboursement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    //
    public function create(Request $request)
    {
        // Logique pour créer un compte utilisateur

        // Validation des données du formulaire
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'password_confirmed' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'date_naissance' => 'required|string',
            'lieu_naissance' => 'required|string',
        ]);

        if ($request->password === $request->password_confirmed) {
// Création d'un nouvel étudiant
            $client = new Client([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
            ]);
            $client->save();

        } else {
            // Message d'erreur en cas d'échec
            return redirect()->route('create-client')->with('error', 'Les mots de passes sont pas equivauts');
        }

    }

    public function show(Request $request, $userId)
    {
        // Afficher le profil de l'utilisateur avec les détails de la demande, remboursements, etc.
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('acceuil');
        }

    }

    public function update(Request $request, $userId)
    {
        // Logique pour mettre à jour les informations du profil client
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('acceuil');
        }

        // Validation des données du formulaire
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'password_confirmed' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'date_naissance' => 'required|string',
            'lieu_naissance' => 'required|string',
        ]);

        Client::where('id', $userId)->update(['email' => '', 'nom' => '', 'prenom' => '', 'sexe' => '', 'adresse' => '', 'date_naissance' => '', 'lieu_naissance' => '']);
    }

    public function rest_to_pay()
    {
        $userId = Session::get('id_utilisateur');

        $remboursement = Remboursement::where('client_id', $userId)->first();
        $remboursement->montant_take;
        $remboursement->montant_payer;
        $reste= $remboursement->montant_take -  $remboursement->montant_payer;
        

    }
}
