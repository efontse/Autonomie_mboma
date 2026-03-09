<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\FormationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ── Routes publiques ──────────────────────────────────────
Route::get('/', fn() => redirect()->route('auth.connexion'));

// Routes pour les informations (publiques)
Route::prefix('informations')->name('informations.')->group(function () {
    Route::get('/', [InformationController::class, 'index'])->name('index');
    Route::get('/{information}', [InformationController::class, 'show'])->name('show');
});

// Authentification
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/connexion',  [AuthController::class, 'showConnexion'])->name('connexion');
    Route::post('/connexion', [AuthController::class, 'connecter'])->name('connecter');

    Route::get('/inscription',  [AuthController::class, 'showInscription'])->name('inscription');
    Route::post('/inscription', [AuthController::class, 'inscrire'])->name('inscrire');

    Route::get('/reset-mdp',  [AuthController::class, 'showResetForm'])->name('reset.form');
    Route::post('/reset-mdp', [AuthController::class, 'envoyerLienReset'])->name('reset.envoyer');

    Route::post('/deconnexion', [AuthController::class, 'deconnecter'])->name('deconnecter');
});

// ── Routes protégées (utilisatrice connectée) ─────────────
Route::middleware(['auth', 'verified'])->group(function () {
    // Tableau de bord - accessible uniquement aux utilisateurs (pas aux modérateurs)
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:utilisateur');

    // Routes pour les informations (création, modification, suppression)
    Route::prefix('informations')->name('informations.')->group(function () {
        Route::get('/creer', [InformationController::class, 'create'])->name('create');
        Route::post('/', [InformationController::class, 'store'])->name('store');
        Route::get('/{information}/editer', [InformationController::class, 'edit'])->name('edit');
        Route::put('/{information}', [InformationController::class, 'update'])->name('update');
        Route::delete('/{information}', [InformationController::class, 'destroy'])->name('destroy');
    });
});

// ── Routes utilisatrices (formations) ─────────────────────
// Note: Les modérateurs n'ont pas accès à ces routes (ils gèrent les formations via admin)
Route::middleware('auth')->prefix('formations')->name('formation.')->group(function () {
    // Liste des formations - accessible uniquement aux utilisateurs (pas aux modérateurs)
    Route::get('/', [FormationController::class, 'index'])->name('index')->middleware('role:utilisateur');
    // Mes formations inscrites - accessible uniquement aux utilisateurs
    Route::get('/mes-formations', [FormationController::class, 'mesFormations'])->name('mes-formations')->middleware('role:utilisateur');
    // Détail d'une formation - accessible uniquement aux utilisateurs
    Route::get('/{formation}', [FormationController::class, 'show'])->name('show')->middleware('role:utilisateur');
    // S'inscrire à une formation - accessible uniquement aux utilisateurs
    Route::post('/{formation}/inscrire', [FormationController::class, 'inscrire'])->name('inscrire')->middleware('role:utilisateur');
    // Mettre à jour la progression (AJAX) - accessible uniquement aux utilisateurs
    Route::post('/{formation}/progression', [FormationController::class, 'progression'])->name('progression')->middleware('role:utilisateur');
});

// ── Routes admin / modération ─────────────────────────────
require __DIR__ . '/admin.php';

