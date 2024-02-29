<?php

namespace App\Http\Controllers;

use App\Jobs\SendValideMarkdownMail;
use App\Mail\ValideMarkdownMail;
use App\Models\Admin;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function update_dette()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
        }

        $clients = DB::table('clients')
            ->leftJoin('demandes', 'clients.id', '=', 'demandes.client_id')
            ->select('clients.*', 'demandes.id as demande_id')
            ->where('demandes.statut', '=', 'valide')
            ->get();

        return view('Admin.update-dette', compact('clients'));

    }
    public function getMontantTotal()
    {
        $montantTotal = Demande::sum('montant_voulu');
        return $montantTotal;
    }
   public function update_montant(Request $request, $id_demande)
{
    // Validation des données du formulaire
    $request->validate([
        'montant_take' => 'required|numeric',
    ]);

    try {
        // Récupérer la demande associée à l'id_demande
        $demande = Demande::findOrFail($id_demande);

        // Vérifier si le montant_restant est déjà à 0, alors ne pas effectuer la mise à jour
        if ($demande->montant_restant == 0) {
            return redirect()->back()->with('error', 'Le montant restant est déjà à 0 pour ce client.');
        }

        // Vérifier si le montant à mettre à jour est supérieur au montant restant
        if ($request->input('montant_take') > $demande->montant_restant) {
            return redirect()->back()->with('error', 'Le montant que vous souhaitez insérer est supérieur au montant restant à payer.');
        }

 
        // Mettre à jour le montant_take et le montant_restant
        $ancienMontant = $demande->montant_take;
        $montantVoulu = $demande->montant_restant;
        $nouveauMontantTake = $ancienMontant + $request->input('montant_take');
        $nouveauMontantRestant = $montantVoulu - $nouveauMontantTake;

        // Mettre à jour la demande
        $demande->update([
            'montant_take' => $nouveauMontantTake,
            'montant_restant' => $nouveauMontantRestant,
        ]);

        return redirect()->back()->with('success', 'Montant mis à jour avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors de la mise à jour du montant.');
    }
}


    public function getDemandeApprouveCount()
    {
        $demandeApprouveCount = Demande::where('statut', 'valide')->count();
        return $demandeApprouveCount;
    }

    public function welcome()
    {
        // Vérifier si l'utilisateur est connecté en tant qu'admin
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
        }

        try {
            $demandes = Demande::with(['client:id,nom,prenom,rib', 'client.user:id,email'])
                ->select('demandes.*', 'clients.nom', 'clients.prenom', 'clients.rib')
                ->join('clients', 'demandes.client_id', '=', 'clients.id')
                ->get();

            // Calcul du montant total
            $montantTotal = $demandes->sum('montant_voulu');

            // Nombre total de demandes
            $demandeCount = $demandes->count();

            // Nombre de demandes approuvées
            $demandeApprouveCount = $demandes->where('statut', 'valide')->count();

            return view('admin.index', compact('demandes', 'demandeCount', 'demandeApprouveCount', 'montantTotal'));
        } catch (\Exception $e) {
            return view('admin.index')->with('error', 'Une erreur est survenue lors de la récupération des demandes.');
        }
    }

    public function listeClients()
    {if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('admin/login');
    }

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
            return redirect()->route('admin/login');
        }

        // Afficher les détails d'un utilisateur spécifique (peut être utilisé pour vérifier les informations)
    }
    public function getDemandeCount()
    {
        $demandeCount = Demande::count();
        return $demandeCount;
    }

    public function dashboard()
    {

        return view('admin.index', compact('demandeCount', 'montantTotal', 'demandeApprouveCount'));
    }

    public function viewLoanRequests()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
        }

        // Récupérer toutes les demandes de prêt avec les informations du client associé
        $loanRequests = Demande::with('client:id,nom,prenom')->get();

        return view('admin.view_loan_requests', compact('loanRequests'));
    }
    public function approuver($id_demande)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
        }

        // Trouver la demande de prêt correspondante par son ID

        $loan = Demande::findOrFail($id_demande);

        // Mettre à jour le champ 'statut' avec la valeur 'valide'
        $loan->update(['statut' => 'valide']);
        $montantMensuel = Session::get('montantmensuel');
        $dureeAnnees = Session::get('dureeAnnees');
        $montant_restant = Session::get('montant_restant');
        $montantDemande = Session::get('montantDemande');
        $email = Session::get('email_utilisateur');
        $prenom = Session::get('prenom');
        $name = Session::get('name');

        $vmailable = new ValideMarkdownMail($montantMensuel, $dureeAnnees, $montant_restant, $montantDemande, $name, $prenom, $email);
        SendValideMarkdownMail::dispatch($vmailable, $email);
        // Rediriger avec un message de succès
        return redirect()->route('valider')->with('success', 'La demande a été validée.');
    }

    public function reject($id_demande)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
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
            return redirect()->route('admin/login');
        }

        $user_mail = Session::get('email-admin');

// Validation des données du formulaire
        $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string',
            'prenom' => 'required|string',

        ]);

// Récupérer l'utilisateur à partir de la base de données
        $admin_tab_user = User::where('email', $user_mail)->first();
        $admin_id = $admin_tab_user->id;
        $admin = Admin::findOrFail($admin_id);

        User::where('email', $user_mail)->update([
            'email' => $request->input('email'),
        ]);

// Mettre à jour les informations du profil client
        $admin->update([
            'email' => $request->input('email'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),

        ]);

// Redirection avec un message de succès
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');

    }
    public function changePassword(Request $request)
    {

        // Assurez-vous que l'utilisateur est authentifié
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('admin/login');
        }

        // Récupérer l'e-mail de l'utilisateur à partir de la session
        $user_email = Session::get('email-admin');

        // Validation des données du formulaire
        $request->validate([
            'password_ancienne' => 'required|min:6',
            'password_new' => 'required|min:6',
        ]);

        // Récupérer l'utilisateur à partir de la base de données
        $admin = User::where('email', $user_email)->first();

        // Vérifier si l'ancien mot de passe correspond
        if (!Hash::check($request->password_ancienne, $admin->password)) {
            // Rediriger avec un message d'erreur
            return redirect()->route('profile')->with('error', 'Votre ancien mot de passe ne correspond pas à celui renseigné');
        }

        // Mettre à jour le mot de passe
        $admin->update([
            'password' => bcrypt($request->password_new),
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('profile')->with('success', 'Mot de passe modifié avec succès.');
    }

}
