<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DemandeController extends Controller
{
    //
    public function create(Request $request)
    {
        // Logique pour créer une demande de prêt
        $userId = Session::get('id_utilisateur');

        // Validation des données du formulaire
        $request->validate([
            'projet' => 'required',
            'description' => 'required',
            'montant_voulue' => 'required',
            'payement_months' => 'required|string',
        ]);
        $demande = new Demande([
            'client_id' => $userId,
            'projet' => $request->projet,
            'description' => $request->description,
            'montant_voulue' => $request->montant_voulue,
            'payement_months' => $request->payement_months,

        ]);
        $demande->save();

    }

    public function index(Request $request)
    {
        // Afficher toutes les demandes de prêt (validées et non validées) à l'administrateur
    }

    public function approve(Request $request, $loanId)
    {
        // Logique pour approuver une demande de prêt
    }

    public function DemandeStatut()
    {
        $userId = Session::get('id_utilisateur');

        $demande = Demande::where('client_id', $userId)->first();
        $statut = $demande->statut;
        if ($statut == 'valide') {
            return view('Client_home')->with('demande_statut', 'Votre demande a déjà été validé');

        } elseif ($statut == 'n_valide') {
            return view('Client_home')->with('demande_statut', 'Votre demande n\'a pas été validé');
        } else {
            return view('Client_home')->with('demande_statut', 'Votre demande est en cours de traitement');

        }
    }

    public function deleteDemande()
    {
        $userId = Session::get('id_utilisateur');

        $demande = Demande::where('client_id', $userId)->first();
        $statut = $demande->statut;
        if ($statut == 'valide') {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer cette demande car elle a été validé déjà');

        } else {
            $demande->delete();
        }
    }

    public function crediteAccount()
    {
        $userId = Session::get('id_utilisateur');

        $demande = Demande::where('client_id', $userId)->first();
        $credite = $demande->credite;
        if ($credite === 1) {
            return view('Client_home')->with('credite_statut', 'Votre compte bancaire a déjà été crédité');

        } elseif ($credite === 0) {
            return view('Client_home')->with('credite_statut', '');
        }

    }

}
