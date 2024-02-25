<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Demande;
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
    {if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('indexpage');
    }

        return view('Client.welcome');
    }

    public function view_login()
    {
        return view('Client.login');

    }
    public function view_givemail()
    {
        return view('Client.givemail');

    }
    public function view_register()
    {

        return view('Client.register');

    }
    public function create(Request $request)
    {

        // Logique pour créer un compte utilisateur

        // Validation des données du formulaire
        $request->validate([

            'email' => 'required|email|unique:clients', //  la règle unique pour s'assurer que l'email est unique dans la table clients
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'date_naissance' => 'required|string',
            'lieu_naissance' => 'required|string',
            'adresse' => 'required|string',
            'sexe' => 'required|string',
            'password' => 'required|min:6',
            'password_confirmed' => 'required|same:password',
        ]);

        // Vérifier si les mots de passe correspondent
        if ($request->password === $request->password_confirmed) {

            // Création de l'utilisateur associé dans la table users
            $user = new User([

                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'client',
            ]);

            $user->save();

            // Création d'un nouveau client
            $client = new Client([
                'id' => $user->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'password' => bcrypt($request->password),
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'adresse' => $request->adresse,
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
            ]);

            $client->save();

            // Redirection avec un message de succès
            return redirect()->route('login')->with('success', 'Compte créé avec succès.');
        } else {
            // Redirection avec un message d'erreur en cas d'échec
            return redirect()->route('register')->with('error', 'Les mots de passe ne sont pas équivalents.');
        }
    }

    public function show(Request $request, $userId)
    {
        // Afficher le profil de l'utilisateur avec les détails de la demande, remboursements, etc.
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

    }

    public function update(Request $request, $userId)
    {

        // Vérifier si l'utilisateur est authentifié
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
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
        return redirect()->route('my_route_name')->with('success', 'Profil mis à jour avec succès.');
    }

    public function rest_to_pay()
    {if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('indexpage');
    }

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

    public function seeDemande()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        // Récupérer les demandes associées à l'utilisateur
        $demandes = Demande::where('client_id', $userId)->get();

        // Passer les demandes à la vue
        return view('Client.mes_demandes', compact('demandes'));
    }

}
