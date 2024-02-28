<?php

namespace App\Http\Controllers;

use App\Models\Client;

use App\Jobs\SendDemandeInfoMarkdownMail;
use App\Jobs\SendDemandeReceiptMarkdownMail;
use App\Mail\DemandeInfoMarkdownMail;
use App\Mail\DemandeReceiptMarkdownMail;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DemandeController extends Controller
{
    //
    public function create(Request $request)
    { // Vérification si le client a déjà une demande en attente
        $userId = Session::get('id_utilisateur');
        $lastDemande = Demande::where('client_id', $userId)->orderBy('created_at', 'desc')->first();


        $demandeEnAttente = Demande::where('client_id', $userId)->where('statut', 'pending')->first();
        $demandeEligble = Demande::where('client_id', $userId)->where('statut', 'valide')->first();
        if ($demandeEnAttente) {
            return back()->with('error', 'Už máte čekající žádost. Prosím, vyčkejte, než podáte novou žádost.');
        }
        if ($demandeEligble) {
            if ($lastDemande && $lastDemande->montant_restant !== 0) {
                return back()->with('error', 'Vous avez encore un montant restant sur une demande précédente.');
            }else{
                return back()->with('error', 'Nejste ještě oprávněni podat novou žádost.');
            }
        }


        // Validation des données du formulaire
        $request->validate([
            'projet' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|numeric|max:25',
            'rib' => 'required',
            'montant_voulue' => 'required|numeric|min:25000',
        ]);

        // Récupération du montant demandé
        $montantDemande = $request->input('montant_voulue');
        Session::put('montantDemande', $montantDemande);

        $dureeAnnees = $request->input('duree');

        // Conversion du taux d'intérêt annuel en taux d'intérêt mensuel
        $tauxInteretAnnuel = 0.04;
        $tauxInteretMensuel = $tauxInteretAnnuel / 12;

        // Nombre total de paiements
        $nombrePaiements = $dureeAnnees * 12;

        // Calcul du montant mensuel à rembourser
        $montantMensuel = ($montantDemande * $tauxInteretMensuel) / (1 - pow(1 + $tauxInteretMensuel, -$nombrePaiements));
        Session::put('montantmensuel', $montantMensuel);
        Session::put('dureeAnnees', $dureeAnnees);

        // Désactiver les contraintes de clé étrangère

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Création de la demande
        $demande = new Demande([
            'projet' => $request->input('projet'),
            'description' => $request->input('description'),
            'montant_voulu' => $montantDemande,
            'duree_remboursement' => $dureeAnnees,
            'payement_months' => $montantMensuel,
            'client_id' => $userId,
            'montant_take' => 0, // Initialiser à 0
            'montant_payer' => 0, // Initialiser à 0
            'montant_restant' => round($montantMensuel*12*$dureeAnnees), // Initialiser à 0
        ]);
        Session::put('montant_restant', $demande->montant_restant);


        Client::where('user_id', $userId)->update([
            'rib' => $request->input('rib'),
        ]);


        // Enregistrement de la demande dans la base de données
        try {
            $demande->save();
            $email = Session::get('email_utilisateur');
            $prenom = Session::get('prenom');
            $nom = Session::get('name');
            $dmailable = new DemandeReceiptMarkdownMail($email);
            $nmailable = new DemandeInfoMarkdownMail($prenom, $nom);
            // Envoyer la tâche à la file d'attente
            SendDemandeInfoMarkdownMail::dispatch($nmailable);
            SendDemandeReceiptMarkdownMail::dispatch($dmailable, $email);
            return redirect()->route('welcome')->with('success', 'Žádost o půjčku byla úspěšně zaregistrována.');

        } catch (\Exception $e) {
            // Erreur d'enregistrement
            return back()->with('error', 'Chyba při registraci žádosti o půjčku.');
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
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        $userId = Session::get('id_utilisateur');
        $demande = Demande::where('client_id', $userId)->first();
        $statut = $demande->statut;
        if ($statut == 'valide') {
            return redirect()->back()->with('error', 'Tuto žádost nelze odstranit, protože již byla schválena.');

        } else {
            $demande->delete();
            return redirect()->back()->with('success', 'Žádost byla úspěšně smazána');
        }
    }

    public function crediteAccount()
    {
        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('indexpage');
        }

        $userId = Session::get('id_utilisateur');

        $demande = Demande::where('client_id', $userId)->first();
        $credite = $demande->credite;
        if ($credite === 1) {
            return view('Client_home')->with('credite_statut', 'Vaše bankovní konto již bylo připsáno');

        } elseif ($credite === 0) {
            return view('Client_home')->with('credite_statut', '');
        }

    }

}
