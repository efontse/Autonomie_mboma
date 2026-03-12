<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\EntrepreneuriatController;
use App\Http\Controllers\CommunauteController;
use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\NotificationController;

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

    // Profil utilisateur
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::put('/profil', [DashboardController::class, 'mettreAJourProfil'])->name('profil.update');
    Route::patch('/profil/mot-de-passe', [DashboardController::class, 'modifierMotDePasse'])->name('profil.password');

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

// ── Routes entrepreneuriat ─────────────────────────────
Route::middleware('auth')->prefix('entrepreneuriat')->name('entrepreneuriat.')->group(function () {
    // Page d'accueil du module
    Route::get('/', [EntrepreneuriatController::class, 'index'])->name('index');

    // Projets entrepreneuriaux
    Route::get('/projets/creer', [EntrepreneuriatController::class, 'createProjet'])->name('projet.create');
    Route::post('/projets', [EntrepreneuriatController::class, 'storeProjet'])->name('projet.store');
    Route::get('/mes-projets', [EntrepreneuriatController::class, 'mesProjets'])->name('mes-projets');
    Route::get('/projets/{projet}', [EntrepreneuriatController::class, 'showProjet'])->name('projet.show');

    // Annonces
    Route::get('/annonces/creer', [EntrepreneuriatController::class, 'createAnnonce'])->name('annonce.create');
    Route::post('/annonces', [EntrepreneuriatController::class, 'storeAnnonce'])->name('annonce.store');
    Route::get('/mes-annonces', [EntrepreneuriatController::class, 'mesAnnonces'])->name('mes-annonces');
    Route::get('/annonces/{annonce}', [EntrepreneuriatController::class, 'showAnnonce'])->name('annonce.show');
    Route::delete('/annonces/{annonce}', [EntrepreneuriatController::class, 'destroyAnnonce'])->name('annonce.destroy');
    Route::patch('/annonces/{annonce}/toggle', [EntrepreneuriatController::class, 'toggleAnnonce'])->name('annonce.toggle');

    // Liste des annonces publiques
    Route::get('/annonces-liste', [EntrepreneuriatController::class, 'listeAnnonces'])->name('annonces.liste');
});

// ── Routes communauté ────────────────────────────────────────
Route::middleware('auth')->prefix('communaute')->name('communaute.')->group(function () {
    Route::get('/', [CommunauteController::class, 'index'])->name('index');
    Route::post('/posts', [CommunauteController::class, 'store'])->name('posts.store');
    Route::post('/reactions', [CommunauteController::class, 'toggleReaction'])->name('reactions.toggle');
    Route::post('/comments', [CommunauteController::class, 'storeComment'])->name('comments.store');
    Route::get('/comments/{postId}', [CommunauteController::class, 'getComments'])->name('comments.index');
    Route::post('/report', [CommunauteController::class, 'report'])->name('report');
});

// ── Routes messagerie ───────────────────────────────────────────
Route::middleware('auth')->prefix('messagerie')->name('messagerie.')->group(function () {
    Route::get('/', [MessagerieController::class, 'index'])->name('index');
    Route::get('/{id}', [MessagerieController::class, 'show'])->name('show');
    Route::post('/{id}/messages', [MessagerieController::class, 'sendMessage'])->name('messages.send');
    Route::get('/{id}/messages', [MessagerieController::class, 'getMessages'])->name('messages.get');
    Route::post('/demarrer/{userId}', [MessagerieController::class, 'startConversation'])->name('start');
    Route::get('/api/unread', [MessagerieController::class, 'getUnreadCount'])->name('unread');
    Route::get('/api/conversations', [MessagerieController::class, 'getConversations'])->name('api.conversations');
});

// ── Routes notifications ──────────────────────────────────────
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
    Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::get('/unread/count', [NotificationController::class, 'unreadCount'])->name('unread.count');
    Route::get('/unread/list', [NotificationController::class, 'unreadList'])->name('unread.list');
});

