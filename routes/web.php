<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
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
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les informations (création, modification, suppression)
    Route::prefix('informations')->name('informations.')->group(function () {
        Route::get('/creer', [InformationController::class, 'create'])->name('create');
        Route::post('/', [InformationController::class, 'store'])->name('store');
        Route::get('/{information}/editer', [InformationController::class, 'edit'])->name('edit');
        Route::put('/{information}', [InformationController::class, 'update'])->name('update');
        Route::delete('/{information}', [InformationController::class, 'destroy'])->name('destroy');
    });
});

// ── Routes admin / modération ─────────────────────────────
Route::middleware(['auth', 'role:admin,moderateur'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', fn() => view('admin.dashboard'))->name('dashboard');
    // TODO: modération des publications
});

use App\Http\Controllers\FormationController;

// ── Routes utilisatrices ──────────────────────────────────
Route::middleware('auth')->prefix('formations')->name('formation.')->group(function () {

    // Liste des formations
    Route::get('/',                          [FormationController::class, 'index'])->name('index');

    // Mes formations inscrites
    Route::get('/mes-formations',            [FormationController::class, 'mesFormations'])->name('mes-formations');

    // Détail d'une formation
    Route::get('/{formation}',               [FormationController::class, 'show'])->name('show');

    // S'inscrire à une formation
    Route::post('/{formation}/inscrire',     [FormationController::class, 'inscrire'])->name('inscrire');

    // Mettre à jour la progression (AJAX)
    Route::post('/{formation}/progression',  [FormationController::class, 'progression'])->name('progression');
});

// ── Routes admin ──────────────────────────────────────────
Route::middleware('auth')->prefix('admin/formations')->name('formation.admin.')->group(function () {

    Route::get('/',                          [FormationController::class, 'adminIndex'])->name('index');
    Route::get('/creer',                     [FormationController::class, 'create'])->name('create');
    Route::post('/',                         [FormationController::class, 'store'])->name('store');
    Route::get('/{formation}/editer',        [FormationController::class, 'edit'])->name('edit');
    Route::put('/{formation}',               [FormationController::class, 'update'])->name('update');
    Route::delete('/{formation}',            [FormationController::class, 'destroy'])->name('destroy');
});
