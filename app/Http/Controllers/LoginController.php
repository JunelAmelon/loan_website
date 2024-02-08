<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{
    //

    public function showLoginForm()
    {
        return view('Client.login');
    }
    public function authenticate(Request $request): RedirectResponse | View
    {
        // Validation des informations de connexion
        $credentials = $request->validate([
            'id_user' => ['required'],
            'password' => ['required'],
        ]);

        // Tentative d'authentification avec les informations fournies
        if (Auth::attempt($credentials)) {
            // Régénération de la session pour des raisons de sécurité
            $request->session()->regenerate();

            // Récupération de l'utilisateur authentifié
            $user = Auth::user();
            $id_user = $user->id_user;
            Session::put('id_utilisateur', $id_user);

            // Vérification du statut de l'utilisateur pour rediriger en conséquence
            if ($user->role == 'client') {
                // Redirection vers la page d'accueil de l'étudiant
                $user = Auth::user();
                $id_user = $user->id_user;
                $client = Client::where('id_client', $id_user)->first();
                Session::put('prenom', $client->prenom);

                return redirect()->route('Client_home')->with('success', 'Connexion réussie en tant que client.');
            } elseif ($user->role === 'admin') {
                $user = Auth::user();
                $id_user = $user->id_user;
                $admin = Admin::where('id_admin', $id_user)->first();
                Session::put('prenom', $admin->prenom);

                // Redirection vers la page d'accueil de l'administrateur
                return redirect()->route('admin')->with('success', 'Connexion réussie en tant qu\'administrateur.');
            } else {
                // Redirection par défaut si le type d'utilisateur n'est pas géré
                return redirect()->route('acceuil')->with('success', 'Type d\'utilisateur non pris en compte');
            }
        }

        // Redirection en arrière avec des erreurs si l'authentification échoue
        return back()
            ->withErrors([
                'id_user' => 'Les informations d\'identification fournies ne correspondent à aucun enregistrement.',
            ]);

    }

    public function deconnexion()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('acceuil');
    }
}
