<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
        //
    public function create(Request $request)
    {   // Vérification si le client a déjà une demande en attente
        $userId = Session::get('id_utilisateur');
        
        $demandeEnAttente = Demande::where('client_id', $userId)->where('statut', 'pending')->first();
        $demandeEligble= Demande::where('client_id', $userId)->where('statut', 'valide')->first();
        if ($demandeEnAttente) {
            return back()->with('error', 'Vous avez déjà une demande en attente. Veuillez patienter avant de soumettre une nouvelle demande.');
        }
        if ($demandeEligble) {
            return back()->with('error', 'Vous n\'etes pas encore eligible pour effectuer une nouvelle demande');
        }

        // Validation des données du formulaire
        $request->validate([
            'projet' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|numeric|max:25',
            'montant_voulue' => 'required|numeric|min:25000',
        ]);

        // Récupération du montant demandé
        $montantDemande = $request->input('montant_voulue');
        $nombreannee=$request->input('duree');
        $montantParMois= (($montantDemande/$nombreannee) + ($montantDemande/$nombreannee)*0.04)/12*$nombreannee;
       
// Désactiver les contraintes de clé étrangère
DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Création de la demande
        $demande = new Demande([
            'projet' => $request->input('projet'),
            'description' => $request->input('description'),
            'montant_voulu' => $montantDemande,
            'duree_remboursement'=> $nombreannee,
            'payement_months' => $montantParMois,
            'client_id' => $userId,
        ]);
 
        // Enregistrement de la demande dans la base de données
        try {
            $demande->save();

            return redirect()->route('welcome')->with('success', 'Demande de prêt enregistrée avec succès.');
        } catch (\Exception $e) {
            // Erreur d'enregistrement
            return back()->with('error', 'Erreur lors de l\'enregistrement de la demande de prêt.');
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

    public function makeDemandeView()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }
        return view('Client.make_demande');

    }

     

    public function reject()
    {if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('indexpage');
    }

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
    {if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('indexpage');
    }

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
