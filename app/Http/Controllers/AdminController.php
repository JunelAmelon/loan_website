<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {

    }

    public function welcome()
    {try {
        $demandes = Demande::with(['client:id,user_id,nom,prenom', 'client.user:id,email'])->get();

        return view('admin.index', ['demandes' => $demandes]);
    } catch (\Exception $e) {
        return view('admin.index')->with('error', 'Une erreur est survenue lors de la récupération des demandes.');
    }

    }

    public function listeClients()
    {
        $clients = DB::table('clients')
            ->leftJoin('demandes', 'clients.id', '=', 'demandes.client_id')
            ->select('clients.*', 'demandes.id as demande_id')
            ->where('demandes.statut', '=', 'pending')
            ->get();

        return view('Admin.valider', compact('clients'));

    }

    public function profileview()
    {
        return view('Admin.users-profile');
    }
    public function login()
    {
        return view('Admin.pages-login');
    }
    public function validate_view()
    {
        return view('Admin.valider');
    }

    public function showUser(Request $request, $userId)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Afficher les détails d'un utilisateur spécifique (peut être utilisé pour vérifier les informations)
    }

    public function viewLoanRequests()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Récupérer toutes les demandes de prêt avec les informations du client associé
        $loanRequests = Demande::with('client:id,nom,prenom')->get();

        return view('admin.view_loan_requests', compact('loanRequests'));
    }
    public function approuver($id_demande)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Trouver la demande de prêt correspondante par son ID
        
        $loan = Demande::findOrFail($id_demande);
        
        // Mettre à jour le champ 'statut' avec la valeur 'valide'
        $loan->update(['statut' => 'valide']);

        // Rediriger avec un message de succès
        return redirect()->route('valider')->with('success', 'La demande a été validée.');
    }

    public function reject($id_demande)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Trouver la demande de prêt correspondante par son ID
        $loan = Demande::findOrFail($id_demande);
        $statut = $loan->statut;
        if ($statut == 'valide') {
            return redirect()->route('valider')->with('error', 'Vous ne pouvez pas rejeter cette demande car elle a été validé déjà');

        } else {
            // Mettre à jour le champ 'statut' avec la valeur 'rejeter'
            $loan->update(['statut' => 'rejeter']);
            // Rediriger avec un message de succès
            return redirect()->route('valider')->with('error', 'La demande a été invalidée.');
        }

         
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }
        $user_mail = Session::get('id_utilisateur');

// Validation des données du formulaire
        $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            // Ajoutez d'autres règles de validation au besoin
        ]);

// Récupérer l'utilisateur à partir de la base de données
        $admin = Admin::findOrFail($user_mail);
        User::where('email', $user_mail)->update([
            'email' => $request->input('email'),
        ]);
// Mettre à jour les informations du profil client
        $admin->update([
            'email' => $request->input('email'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'sexe' => $request->input('sexe'),
            'date_naissance' => $request->input('date_naissance'),
            'lieu_naissance' => $request->input('lieu_naissance'),
        ]);

// Redirection avec un message de succès
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');

    }
    public function changePassword(Request $request)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }
        $user_mail = Session::get('email-admin');

// Validation des données du formulaire
        $request->validate([
            'password_ancienne' => 'nullable|min:6',
            'password_new' => 'nullable|same:password',
            'password_confirmed' => 'nullable|same:password_new',

        ]);

        $admin = Admin::where('email', $user_mail)->first();
        if ($request->password_ancienne != $admin->password) {
            // Rediriger avec un message d'erreur
            return redirect()->route('profile')->with('error', 'Votre ancien mot de passe ne correspond pas à celui renseigné');

        } elseif ($request->password_ancienne == $admin->password) {
            if ($request->password_new != $admin->password_confirmed) {
// Rediriger avec un message d'erreur
                return redirect()->route('profile')->with('error', 'Les mots de passe ne sont pas conforme ');

            }

        }

        Admin::where('email', $user_mail)->update([
            'password' => $request->input('password_new'),
        ]);
    }

}
