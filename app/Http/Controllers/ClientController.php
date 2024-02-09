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

    public function indexpage()
    {
        return view('Client.home');
    }
     public function welcome()
    {
        return view('Client.welcome');
    }
   
     public function view_login(){
        return view('Client.login');

    }

    public function create(Request $request)
    {
        // Logique pour créer un compte utilisateur

        // Validation des données du formulaire
        $request->validate([
            'email' => 'required|email|unique:clients', // Ajoutez la règle unique pour s'assurer que l'email est unique dans la table clients
            'password' => 'required|min:6', // Vous pouvez personnaliser les règles de validation du mot de passe
            'password_confirmed' => 'required|same:password',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'date_naissance' => 'required|string',
            'lieu_naissance' => 'required|string',
        ]);

        // Vérifier si les mots de passe correspondent
        if ($request->password === $request->password_confirmed) {
            // Création d'un nouveau client
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

            // Création de l'utilisateur associé dans la table users
            $user = new User([
                'id_user' => $client->id,
                'password' => bcrypt($request->password),
                'role' => 'client',
            ]);

            $user->save();

            // Redirection avec un message de succès
            return redirect()->route('nom_de_votre_route')->with('success', 'Compte créé avec succès.');
        } else {
            // Redirection avec un message d'erreur en cas d'échec
            return redirect()->route('create-client')->with('error', 'Les mots de passe ne sont pas équivalents.');
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
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check() || Auth::user()->id != $userId) {
            Auth::logout();
            return redirect()->route('acceuil');
        }

        // Validation des données du formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:6', // Vous pouvez personnaliser les règles de validation du mot de passe
            'password_confirmation' => 'nullable|same:password',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        // Récupérer l'utilisateur à partir de la base de données
        $client = Client::findOrFail($userId);

        // Mettre à jour les informations du profil client
        $client->update([
            'email' => $request->input('email'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'sexe' => $request->input('sexe'),
            'date_naissance' => $request->input('date_naissance'),
            'lieu_naissance' => $request->input('lieu_naissance'),
            // Ajoutez d'autres champs à mettre à jour au besoin
        ]);

        // Mettre à jour le mot de passe uniquement s'il est fourni dans le formulaire
        if ($request->filled('password')) {
            $client->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }

        // Redirection avec un message de succès
        return redirect()->route('nom_de_votre_route')->with('success', 'Profil mis à jour avec succès.');
    }

    public function rest_to_pay()
    {
        // Récupérer l'ID de l'utilisateur depuis la session (assurez-vous que la session contient l'ID)
        $userId = Session::get('id_utilisateur');

        // Rechercher le remboursement associé à l'utilisateur
        $remboursement = Remboursement::where('client_id', $userId)->first();

        if ($remboursement) {
            // Calculer le montant restant à payer
            $montantRestant = $remboursement->montant_take - $remboursement->montant_payer;

            // Passer la valeur à la vue
            return view('nom_de_votre_vue', ['montantRestant' => $montantRestant]);
        } else {
            // Gérer le cas où aucun remboursement n'est trouvé
            return view('nom_de_votre_vue', ['montantRestant' => 0]); // Ou une valeur par défaut
        }
    }

}
