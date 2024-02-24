<?php

use App\Http\Controllers\DemandeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//clients routes
Route::get('/', [ClientController::class, 'indexpage'])->name('indexpage');
Route::get('/login', [ClientController::class, 'view_login'])->name('login');
Route::get('/votre-compte', [ClientController::class, 'view_givemail'])->name('givemail');
Route::post('/send-code', [LoginController::class, 'sendResetCode'])->name('sendcode');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('updatePassword');
Route::post('/check-code', [LoginController::class, 'checkResetCode'])->name('checkResetCode'); 
Route::get('/verify', [LoginController::class, 'verifycode_template'])->name('verifycode');
Route::get('/register', [ClientController::class, 'view_register'])->name('register');
Route::post('/register/treat', [ClientController::class, 'create'])->name('registerTreat');
Route::get('/welcome', [ClientController::class, 'welcome'])->name('welcome');
Route::get('/mes-demandes', [ClientController::class, 'seeDemande'])->name('mes-demandes');
Route::get('/demande', [DemandeController::class, 'makeDemandeView'])->name('demande');
Route::post('/demande-pret', [DemandeController::class, 'create'])->name('demande-pret');
Route::post('/annuler-demande', [DemandeController::class, 'deleteDemande'])->name('annuler-demande');



//admin routes
Route::get('admin/login', [AdminController::class, 'login'])->name('admin/login');
Route::get('/dashboard', [AdminController::class, 'welcome'])->name('welcome-admin');  
Route::get('/profile', [AdminController::class, 'profileview'])->name('profile'); 
Route::get('/valider', [AdminController::class, 'listeClients'])->name('valider');
Route::get('/approuver', [AdminController::class, 'approve'])->name('approuver');
Route::get('/rejeter', [AdminController::class, 'reject'])->name('reject');
Route::post('/change-password', [AdminController::class, 'changePassword'])->name('changePassword');

Route::post('/approuver/{id_demande}', [AdminController::class, 'approuver'])->name('approuver');
Route::post('/reject/{id_demande}', [AdminController::class, 'reject'])->name('reject');



//authentication
Route::post('login', [LoginController::class, 'authenticate'])->name('signTreat');
Route::get('/deconnexion', [LoginController::class, 'deconnexion'])->name('deconnexion');

