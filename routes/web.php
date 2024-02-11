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
Route::get('/register', [ClientController::class, 'view_register'])->name('register');
Route::post('/register/treat', [ClientController::class, 'create'])->name('registerTreat');
Route::get('/welcome', [ClientController::class, 'welcome'])->name('welcome');
Route::get('/mes-demandes', [DemandeController::class, 'seeDemande'])->name('mes-demandes');
Route::get('/demande', [DemandeController::class, 'makeDemandeView'])->name('demande');
Route::post('/demande-pret', [DemandeController::class, 'create'])->name('demande-pret');
Route::post('/annuler-demande', [DemandeController::class, 'deleteDemande'])->name('annuler-demande');



//admin routes
Route::get('admin/login', [AdminController::class, 'login'])->name('admin/login');
Route::get('/dashboard', [AdminController::class, 'welcome'])->name('welcome-admin');  
Route::get('/profile', [AdminController::class, 'profileview'])->name('profile'); 
Route::get('/valider', [AdminController::class, 'validate_view'])->name('valider');




Route::post('login', [LoginController::class, 'authenticate'])->name('signTreat');
Route::get('/deconnexion', [LoginController::class, 'deconnexion'])->name('deconnexion');

