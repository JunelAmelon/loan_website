<?php

use App\Http\Controllers\DemandeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

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
Route::get('login-user', [ClientController::class, 'view_login']);
Route::get('/welcome', [ClientController::class, 'welcome'])->name('welcome');
Route::post('/demande-pret', [DemandeController::class, 'create'])->name('demande-pret');
Route::post('/annuler-demande', [DemandeController::class, 'deleteDemande'])->name('annuler-demande');



//admin routes
Route::get('/login', [ClientController::class, 'welcome'])->name('login-admin');
Route::get('/dashboard', [ClientController::class, 'welcome'])->name('welcome-admin');

