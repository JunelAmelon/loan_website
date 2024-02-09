<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;




class AdminController extends Controller
{
    //
     public function index(Request $request) {
        // Afficher les informations administratives, demandes de prêt, montants à rembourser, etc.
    }

    public function showUser(Request $request, $userId) {
        // Afficher les détails d'un utilisateur spécifique (peut être utilisé pour vérifier les informations)
    }

          public function viewLoanRequests() {
        // Récupérer toutes les demandes de prêt avec les informations du client associé
        $loanRequests = Demande::with('client:id,nom,prenom')->get();

        return view('admin.view_loan_requests', compact('loanRequests'));
    }
        public function validateLoan($loanId) {
        // Trouver la demande de prêt correspondante par son ID
        $loan = Demande::findOrFail($loanId);

        // Mettre à jour le champ 'statut' avec la valeur 'valide'
        $loan->update(['statut' => 'valide']);
        
        // Rediriger avec un message de succès
        return redirect()->route('nom_de_votre_route')->with('success', 'La demande a été validée.');
    }


     public function invalidateLoan($loanId) {
        // Trouver la demande de prêt correspondante par son ID
        $loan = Demande::findOrFail($loanId);

        // Mettre à jour le champ 'statut' avec la valeur 'non_valide'
        $loan->update(['statut' => 'non_valide']);
        
        // Rediriger avec un message de succès
        return redirect()->route('nom_de_votre_route')->with('success', 'La demande a été invalidée.');
    }

 
}
