<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Formation;
use App\Models\Information;
use App\Models\Publication;
use App\Models\ProjetEntrepreneurial;
use App\Models\InscriptionFormation;
use App\Models\CategorieFormation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard - redirige selon le rôle
     */
    public function dashboard()
    {
        // Rediriger vers le bon dashboard selon le rôle
        if (Auth::user()->role === 'moderateur') {
            return $this->moderatorDashboard();
        }

        // Dashboard admin complet
        $stats = [
            'utilisateurs' => User::count(),
            'formations' => Formation::count(),
            'informations' => \App\Models\Information::count(),
            'publications' => \App\Models\Publication::count(),
            'projets' => \App\Models\ProjetEntrepreneurial::count(),
            'annonces' => \App\Models\Annonce::count(),
            'inscriptions' => InscriptionFormation::count(),
        ];

        // Statistiques entrepreneuriat - projets par statut
        $projetsParStatut = \App\Models\ProjetEntrepreneurial::select('statut')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('statut')
            ->get();

        // Statistiques entrepreneuriat - annonces par statut
        $annoncesParStatut = \App\Models\Annonce::select('statut')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('statut')
            ->get();

        // Projets récents
        $projetsRecents = \App\Models\ProjetEntrepreneurial::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Annonces récentes
        $annoncesRecentes = \App\Models\Annonce::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers utilisateurs inscrits
        $derniersUtilisateurs = User::orderBy('created_at', 'desc')->limit(5)->get();

        // Utilisateurs par rôle
        $utilisateursParRole = User::select('role')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('role')
            ->get();

        // Formations avec nombre d'inscriptions
        $formationsPopulaires = Formation::withCount('inscriptions')
            ->orderBy('inscriptions_count', 'desc')
            ->limit(5)
            ->get();

        // Inscriptions par catégorie
        $categories = \App\Models\CategorieFormation::with('formations')->get();
        $inscriptionsParCategorie = $categories->map(function($categorie) {
            $inscriptions = 0;
            foreach ($categorie->formations as $formation) {
                $inscriptions += $formation->inscriptions()->count();
            }
            return [
                'nom' => $categorie->nom,
                'inscriptions' => $inscriptions
            ];
        });

        // Inscriptions par mois (derniers 6 mois)
        $inscriptionsParMois = InscriptionFormation::selectRaw(
            "DATE_FORMAT(inscrit_le, '%Y-%m') as mois, COUNT(*) as total"
        )
            ->where('inscrit_le', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Total des inscriptions
        $totalInscriptions = InscriptionFormation::count();

        // Formations terminées
        $formationsTerminees = InscriptionFormation::where('termine', true)->count();

        return view('admin.dashboard',
            compact(
                'stats',
                'derniersUtilisateurs',
                'utilisateursParRole',
                'formationsPopulaires',
                'inscriptionsParCategorie',
                'inscriptionsParMois',
                'totalInscriptions',
                'formationsTerminees',
                'projetsParStatut',
                'annoncesParStatut',
                'projetsRecents',
                'annoncesRecentes'
            )
        );
    }

    /**
     * Dashboard modérateur - données limitées
     */
    public function moderatorDashboard()
    {
        $stats = [
            'formations' => Formation::count(),
            'informations' => \App\Models\Information::count(),
            'inscriptions' => InscriptionFormation::count(),
        ];

        // Formations avec nombre d'inscriptions
        $formationsPopulaires = Formation::withCount('inscriptions')
            ->orderBy('inscriptions_count', 'desc')
            ->limit(5)
            ->get();

        // Inscriptions par catégorie
        $categories = \App\Models\CategorieFormation::with('formations')->get();
        $inscriptionsParCategorie = $categories->map(function($categorie) {
            $inscriptions = 0;
            foreach ($categorie->formations as $formation) {
                $inscriptions += $formation->inscriptions()->count();
            }
            return [
                'nom' => $categorie->nom,
                'inscriptions' => $inscriptions
            ];
        });

        // Inscriptions par mois (derniers 6 mois)
        $inscriptionsParMois = InscriptionFormation::selectRaw(
            "DATE_FORMAT(inscrit_le, '%Y-%m') as mois, COUNT(*) as total"
        )
            ->where('inscrit_le', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Total des inscriptions
        $totalInscriptions = InscriptionFormation::count();

        // Formations terminées
        $formationsTerminees = InscriptionFormation::where('termine', true)->count();

        return view('admin.dashboard-moderateur',
            compact(
                'stats',
                'formationsPopulaires',
                'inscriptionsParCategorie',
                'inscriptionsParMois',
                'totalInscriptions',
                'formationsTerminees'
            )
        );
    }

    /**
     * Profil de l'utilisateur connecté
     */
    public function profil()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    /**
     * Mettre à jour le profil
     */
    public function mettreAJourProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->prenom = $request->prenom;
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.profil')->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Liste des utilisateurs
     */
    public function utilisateurs()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.utilisateurs.index', compact('users'));
    }

    /**
     * Afficher un utilisateur
     */
    public function voirUtilisateur(User $user)
    {
        return view('admin.utilisateurs.show', compact('user'));
    }

    /**
     * Formulaire de modification d'un utilisateur
     */
    public function editerUtilisateur(User $user)
    {
        return view('admin.utilisateurs.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function mettreAJourUtilisateur(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:utilisateur,moderateur,admin',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function supprimerUtilisateur(User $user)
    {
        // Empêcher la suppression de soi-même
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Liste des formations (admin)
     */
    public function formations()
    {
        $formations = Formation::with(['categorie', 'auteur', 'inscriptions'])
            ->withCount('inscriptions')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.formations.index', compact('formations'));
    }

    /**
     * Créer une formation
     */
    public function creerFormation()
    {
        $categories = \App\Models\CategorieFormation::orderBy('nom')->get();
        return view('admin.formations.create', compact('categories'));
    }

    /**
     * Enregistrer une formation
     */
    public function enregistrerFormation(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories_formation,id',
            'type' => 'required|in:video,document,article,mixte',
            'niveau' => 'required|in:debutant,intermediaire,avance',
            'duree_minutes' => 'required|integer|min:1',
            'video_url' => 'nullable|url',
            'document_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        Formation::create([
            'categorie_id' => $request->categorie_id,
            'auteur_id' => Auth::id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'contenu' => $request->contenu,
            'type' => $request->type,
            'video_url' => $request->video_url,
            'document_url' => $request->document_url,
            'image_url' => $request->image_url,
            'duree_minutes' => $request->duree_minutes,
            'niveau' => $request->niveau,
            'statut' => 'publie',
            'vues' => 0,
        ]);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation créée avec succès.');
    }

    /**
     * Modifier une formation
     */
    public function editerFormation(Formation $formation)
    {
        $categories = \App\Models\CategorieFormation::orderBy('nom')->get();
        return view('admin.formations.edit', compact('formation', 'categories'));
    }

    /**
     * Mettre à jour une formation
     */
    public function mettreAJourFormation(Request $request, Formation $formation)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories_formation,id',
            'type' => 'required|in:video,document,article,mixte',
            'niveau' => 'required|in:debutant,intermediaire,avance',
            'duree_minutes' => 'required|integer|min:1',
            'statut' => 'required|in:brouillon,publie,archive',
        ]);

        $formation->update($request->all());

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation mise à jour avec succès.');
    }

    /**
     * Supprimer une formation
     */
    public function supprimerFormation(Formation $formation)
    {
        $formation->inscriptions()->delete();
        $formation->delete();

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée avec succès.');
    }

    /**
     * Liste des informations (admin)
     */
    public function informations()
    {
        $informations = Information::with('auteur')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.informations.index', compact('informations'));
    }

    /**
     * Créer une information
     */
    public function creerInformation()
    {
        return view('admin.informations.create');
    }

    /**
     * Enregistrer une information
     */
    public function enregistrerInformation(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|in:article,actualite,annonce',
        ]);

        Information::create([
            'auteur_id' => Auth::id(),
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'type' => $request->type,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('admin.informations.index')
            ->with('success', 'Information créée avec succès.');
    }

    /**
     * Modifier une information
     */
    public function editerInformation(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    /**
     * Mettre à jour une information
     */
    public function mettreAJourInformation(Request $request, Information $information)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|in:article,actualite,annonce',
        ]);

        $information->update($request->all());

        return redirect()->route('admin.informations.index')
            ->with('success', 'Information mise à jour avec succès.');
    }

    /**
     * Supprimer une information
     */
    public function supprimerInformation(Information $information)
    {
        $information->delete();

        return redirect()->route('admin.informations.index')
            ->with('success', 'Information supprimée avec succès.');
    }

    /**
     * Catégories de formations
     */
    public function categories()
    {
        $categories = \App\Models\CategorieFormation::orderBy('nom')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Créer une catégorie
     */
    public function creerCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:20',
        ]);

        \App\Models\CategorieFormation::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Supprimer une catégorie
     */
    public function supprimerCategorie(\App\Models\CategorieFormation $categorie)
    {
        // Vérifier si des formations utilisent cette catégorie
        if ($categorie->formations()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des formations.');
        }

        $categorie->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    // ═══════════════════════════════════════════════════════
    // GESTION DES PROJETS ENTREPRENEURIAUX (BACKOFFICE)
    // ═══════════════════════════════════════════════════════

    /**
     * Liste des projets entrepreneuriaux
     */
    public function projets()
    {
        $projets = ProjetEntrepreneurial::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.entrepreneuriat.projets', compact('projets'));
    }

    /**
     * Afficher un projet
     */
    public function voirProjet(ProjetEntrepreneurial $projet)
    {
        return view('admin.entrepreneuriat.projet-show', compact('projet'));
    }

    /**
     * Approuver un projet
     */
    public function approuverProjet(ProjetEntrepreneurial $projet)
    {
        $projet->statut = 'approuve';
        $projet->save();

        return redirect()->back()
            ->with('success', 'Projet approuvé avec succès.');
    }

    /**
     * Rejeter un projet
     */
    public function rejeterProjet(ProjetEntrepreneurial $projet)
    {
        $projet->statut = 'rejete';
        $projet->save();

        return redirect()->back()
            ->with('success', 'Projet rejeté avec succès.');
    }

    /**
     * Mettre en attente un projet
     */
    public function mettreEnAttenteProjet(ProjetEntrepreneurial $projet)
    {
        $projet->statut = 'en_attente';
        $projet->save();

        return redirect()->back()
            ->with('success', 'Projet mis en attente.');
    }

    /**
     * Supprimer un projet
     */
    public function supprimerProjet(ProjetEntrepreneurial $projet)
    {
        $projet->delete();

        return redirect()->route('admin.entrepreneuriat.projets')
            ->with('success', 'Projet supprimé avec succès.');
    }

    // ═══════════════════════════════════════════════════════
    // GESTION DES ANNONCES (BACKOFFICE)
    // ═══════════════════════════════════════════════════════

    /**
     * Liste des annonces
     */
    public function annonces()
    {
        $annonces = \App\Models\Annonce::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.entrepreneuriat.annonces', compact('annonces'));
    }

    /**
     * Afficher une annonce
     */
    public function voirAnnonce(\App\Models\Annonce $annonce)
    {
        return view('admin.entrepreneuriat.annonce-show', compact('annonce'));
    }

    /**
     * Activer une annonce
     */
    public function activerAnnonce(\App\Models\Annonce $annonce)
    {
        $annonce->statut = 'actif';
        $annonce->save();

        return redirect()->back()
            ->with('success', 'Annonce activée avec succès.');
    }

    /**
     * Désactiver une annonce
     */
    public function desactiverAnnonce(\App\Models\Annonce $annonce)
    {
        $annonce->statut = 'inactif';
        $annonce->save();

        return redirect()->back()
            ->with('success', 'Annonce désactivée avec succès.');
    }

    /**
     * Supprimer une annonce
     */
    public function supprimerAnnonce(\App\Models\Annonce $annonce)
    {
        $annonce->delete();

        return redirect()->route('admin.entrepreneuriat.annonces')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}
