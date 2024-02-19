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
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Tentative d'authentification avec les informations fournies
        if (Auth::attempt($credentials)) {
            // Régénération de la session pour des raisons de sécurité
            $request->session()->regenerate();

            // Récupération de l'utilisateur authentifié
            $user = Auth::user();
            $email = $user->email;
            $id= $user->id;
            Session::put('email_utilisateur', $email);
             Session::put('id_utilisateur', $id);

            // Vérification du statut de l'utilisateur pour rediriger en conséquence
            if ($user->role == 'client') {
                // Redirection vers la page d'accueil de l'étudiant
                $user = Auth::user();
                $email_user = $user->email;
                $client = Client::where('email', $email_user)->first();
                Session::put('prenom', $client->prenom);
                Session::put('email',  $email_user);
                return redirect()->route('welcome')->with('success', 'Connexion réussie en tant que client.');
            } elseif ($user->role === 'admin') {
                $user = Auth::user();
                $email_admin = $user->email;
                $admin = Admin::where('id', $id)->first();
                Session::put('prenom', $admin->prenom);
                Session::put('email-admin', $email_admin);
                // Redirection vers la page d'accueil de l'administrateur
                return redirect()->route('welcome-admin')->with('success', 'Connexion réussie en tant qu\'administrateur.');
            } else {
                // Redirection par défaut si le type d'utilisateur n'est pas géré
                return redirect()->route('indexpage')->with('error', 'Type d\'utilisateur non pris en compte');
            }
        }

        // Redirection en arrière avec des erreurs si l'authentification échoue
        return back()
            ->withErrors([
                'email' => 'Les informations d\'identification fournies ne correspondent à aucun enregistrement.',
            ]);

    }

    public function deconnexion()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('indexpage');
    }
}
