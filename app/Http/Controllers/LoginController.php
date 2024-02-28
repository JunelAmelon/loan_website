<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Client;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\CodeResetMarkdownMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Jobs\SendCodeResetMarkdownMail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //

    public function showLoginForm()
    {
        return view('Client.login');
    }

    public function verifycode_template(): View
    {
        return view('Client.verifycode');

    }
    public function updatePasswordPage(): View
    {
        return view('Client.resetpassword_page');

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
            $id = $user->id;
            Session::put('email_utilisateur', $email);
            Session::put('id_utilisateur', $id);

            // Vérification du statut de l'utilisateur pour rediriger en conséquence
            if ($user->role == 'client') {
                // Redirection vers la page d'accueil de l'étudiant
                $user = Auth::user();
                $email_user = $user->email;
                $client = Client::where('email', $email_user)->first();
                Session::put('prenom', $client->prenom);
                Session::put('name', $client->nom);
                Session::put('email', $email_user);
                return redirect()->route('welcome')->with('success-connect', 'Přihlášení úspěšné jako klient.');
            } elseif ($user->role === 'admin') {
                $user = Auth::user();
                $email_admin = $user->email;
                $admin = Admin::where('id', $id)->first();
                Session::put('prenom-admin', $admin->prenom);
                Session::put('email-admin', $email_admin);
                // Redirection vers la page d'accueil de l'administrateur
                return redirect()->route('welcome-admin')->with('success-connect', 'Přihlášení jako správce proběhlo úspěšně.');
            } else {
                // Redirection par défaut si le type d'utilisateur n'est pas géré
                return redirect()->route('indexpage')->with('error', 'Typ uživatele není podporován');
            }
        }

        // Redirection en arrière avec des erreurs si l'authentification échoue
        return back()
            ->withErrors([
                'email' => 'Poskytnuté přihlašovací údaje neodpovídají žádnému záznamu.',
            ]);

    }

    public function deconnexion()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('indexpage');
    }

    public function deconnexion_admin()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('admin/login');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        Session::put('email_password_reset', $request->email);
        $user = User::where('email', Session::get('email_password_reset'))->first();

        if (!$user) {
            return back()->with('error', 'S touto e-mailovou adresou nebyl nalezen žádný uživatel.');
        }

        // Générer un code aléatoire
        $resetCode = Str::random(6); // ajustez la longueur du code selon vos besoins

        // Enregistrez le code dans la base de données
        $user->update([
            'reset_code' => $resetCode,
            'reset_code_expires_at' => now()->addMinutes(15), // expire dans 15 minutes
        ]);

        // Envoyer le code par e-mail
        // c'est ici que le code doit etre send par email.
        $cmailable = new CodeResetMarkdownMail($resetCode, $user->email);
        // Envoyer la tâche à la file d'attente
        SendCodeResetMarkdownMail::dispatch($cmailable, $user->email);

        return redirect()->route('verifycode')->with('success', 'Na vaši e-mailovou adresu byl odeslán kód pro obnovení, zadejte ho');
    }

    public function checkResetCode(Request $request)
    {
        $request->validate([
            'reset_code' => 'required|string',
        ]);

        $user = User::where('email', Session::get('email_password_reset'))->first();

        if (!$user) {
            return back()->with('error', 'Žádný uživatel s tímto e-mailem nebyl nalezen.');
        }

        // Vérifions si le code est correct
        if ($user->reset_code !== $request->input('reset_code')) {
            return back()->with('error', 'Zadaný resetovací kód je nesprávný.');
        }

        // Vérifions si le code n'a pas expiré
        if (Carbon::parse($user->reset_code_expires_at)->isPast()) {
            return back()->with('error', 'Resetovací kód vypršel platnost. Požádejte o nový.');
        }

        // Si tout est en ordre, redirigez l'utilisateur vers la page de réinitialisation du mot de passe
        return redirect()->route('updatePasswordPage');

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        // Récupérez l'utilisateur par l'adresse e-mail
        $user = User::where('email', Session::get('email_password_reset'))->first();

        // Vérifiez si le code de réinitialisation est valide et n'a pas expiré
        if ($user && now()->lt($user->reset_code_expires_at)) {
            // Mettez à jour le mot de passe
            $user->update([
                'password' => bcrypt($request->input('password')),
                'reset_code' => null,
                'reset_code_expires_at' => null,
            ]);

            // Redirigez l'utilisateur vers la page de connexion avec un message de succès
            return redirect('login')->with('success', 'Vaše heslo bylo úspěšně aktualizováno. Přihlaste se s novým heslem.');
        } else {
// Si le code de réinitialisation est invalide ou expiré, redirigez l'utilisateur avec un message d'erreur
            return redirect('updatePasswordPage')->with('error', 'Resetovací kód je neplatný nebo vypršel. Prosím, zkuste to znovu.');

        }

    }
}
