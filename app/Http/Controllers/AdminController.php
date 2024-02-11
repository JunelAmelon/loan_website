<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        // Afficher les informations administratives, demandes de prêt, montants à rembourser, etc.
    }

    public function welcome()
    {
        return view('Admin.index');
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
    public function validateLoan($loanId)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Trouver la demande de prêt correspondante par son ID
        $loan = Demande::findOrFail($loanId);

        // Mettre à jour le champ 'statut' avec la valeur 'valide'
        $loan->update(['statut' => 'valide']);

        // Rediriger avec un message de succès
        return redirect()->route('nom_de_votre_route')->with('success', 'La demande a été validée.');
    }

    public function invalidateLoan($loanId)
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        // Trouver la demande de prêt correspondante par son ID
        $loan = Demande::findOrFail($loanId);

        // Mettre à jour le champ 'statut' avec la valeur 'non_valide'
        $loan->update(['statut' => 'non_valide']);

        // Rediriger avec un message de succès
        return redirect()->route('nom_de_votre_route')->with('success', 'La demande a été invalidée.');
    }

}
