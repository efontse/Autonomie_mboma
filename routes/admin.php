<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/

// Routes accessibles aux administrateurs uniquement
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestion des utilisateurs (ADMIN SEULEMENT)
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs.index');
    Route::get('/utilisateurs/{user}', [AdminController::class, 'voirUtilisateur'])->name('utilisateurs.show');
    Route::get('/utilisateurs/{user}/editer', [AdminController::class, 'editerUtilisateur'])->name('utilisateurs.edit');
    Route::put('/utilisateurs/{user}', [AdminController::class, 'mettreAJourUtilisateur'])->name('utilisateurs.update');
    Route::delete('/utilisateurs/{user}', [AdminController::class, 'supprimerUtilisateur'])->name('utilisateurs.destroy');
});

// Routes accessibles aux administrateurs et modérateurs
Route::middleware(['auth', 'role:admin,moderateur'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard - different for admin and moderator
    Route::get('/tableau-de-bord', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminController::class, 'mettreAJourProfil'])->name('profil.update');

    // Gestion des formations
    Route::get('/formations', [AdminController::class, 'formations'])->name('formations.index');
    Route::get('/formations/creer', [AdminController::class, 'creerFormation'])->name('formations.create');
    Route::post('/formations', [AdminController::class, 'enregistrerFormation'])->name('formations.store');
    Route::get('/formations/{formation}/editer', [AdminController::class, 'editerFormation'])->name('formations.edit');
    Route::put('/formations/{formation}', [AdminController::class, 'mettreAJourFormation'])->name('formations.update');
    Route::delete('/formations/{formation}', [AdminController::class, 'supprimerFormation'])->name('formations.destroy');

    // Gestion des informations
    Route::get('/informations', [AdminController::class, 'informations'])->name('informations.index');
    Route::get('/informations/creer', [AdminController::class, 'creerInformation'])->name('informations.create');
    Route::post('/informations', [AdminController::class, 'enregistrerInformation'])->name('informations.store');
    Route::get('/informations/{information}/editer', [AdminController::class, 'editerInformation'])->name('informations.edit');
    Route::put('/informations/{information}', [AdminController::class, 'mettreAJourInformation'])->name('informations.update');
    Route::delete('/informations/{information}', [AdminController::class, 'supprimerInformation'])->name('informations.destroy');

    // Gestion des catégories de formations
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'creerCategorie'])->name('categories.store');
    Route::delete('/categories/{categorie}', [AdminController::class, 'supprimerCategorie'])->name('categories.destroy');

    // ═══════════════════════════════════════════════════════
    // GESTION DU MODULE ENTREPRENEURIAT
    // ═══════════════════════════════════════════════════════

    // Projets entrepreneuriaux
    Route::get('/projets', [AdminController::class, 'projets'])->name('entrepreneuriat.projets.index');
    Route::get('/projets/{projet}', [AdminController::class, 'voirProjet'])->name('entrepreneuriat.projets.show');
    Route::patch('/projets/{projet}/approuver', [AdminController::class, 'approuverProjet'])->name('entrepreneuriat.projets.approuver');
    Route::patch('/projets/{projet}/rejeter', [AdminController::class, 'rejeterProjet'])->name('entrepreneuriat.projets.rejeter');
    Route::patch('/projets/{projet}/attendre', [AdminController::class, 'mettreEnAttenteProjet'])->name('entrepreneuriat.projets.attendre');
    Route::delete('/projets/{projet}', [AdminController::class, 'supprimerProjet'])->name('entrepreneuriat.projets.destroy');

    // Annonces
    Route::get('/annonces', [AdminController::class, 'annonces'])->name('entrepreneuriat.annonces.index');
    Route::get('/annonces/{annonce}', [AdminController::class, 'voirAnnonce'])->name('entrepreneuriat.annonces.show');
    Route::patch('/annonces/{annonce}/activer', [AdminController::class, 'activerAnnonce'])->name('entrepreneuriat.annonces.activer');
    Route::patch('/annonces/{annonce}/desactiver', [AdminController::class, 'desactiverAnnonce'])->name('entrepreneuriat.annonces.desactiver');
    Route::delete('/annonces/{annonce}', [AdminController::class, 'supprimerAnnonce'])->name('entrepreneuriat.annonces.destroy');
});
