<?php

namespace App\Http\Controllers;

use App\Models\ProjetEntrepreneurial;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrepreneuriatController extends Controller
{
    /**
     * Liste des secteurs d'activité
     */
    public static function getSecteurs()
    {
        return [
            'agriculture_elevage' => 'Agriculture / Élevage',
            'commerce_vente' => 'Commerce / Vente',
            'artisanat' => 'Artisanat',
            'numerique_services' => 'Numérique / Services',
            'transformation_alimentaire' => 'Transformation alimentaire',
            'sante_bien_etre' => 'Santé / Bien-être',
        ];
    }

    /**
     * Page d'accueil du module entrepreneuriat
     */
    public function index()
    {
        $projets = ProjetEntrepreneurial::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('entrepreneuriat.index', compact('projets'));
    }

    /**
     * Afficher le formulaire de soumission d'un projet
     */
    public function createProjet()
    {
        $secteurs = self::getSecteurs();
        return view('entrepreneuriat.projet-create', compact('secteurs'));
    }

    /**
     * Soumettre un nouveau projet entrepreneurial
     */
    public function storeProjet(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'secteur' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $projet = new ProjetEntrepreneurial();
        $projet->user_id = Auth::id();
        $projet->titre = $request->titre;
        $projet->description = $request->description;
        $projet->secteur = $request->secteur;
        $projet->budget = $request->budget;
        $projet->statut = 'en_attente';
        $projet->date_soumission = now();
        $projet->save();

        return redirect()->route('entrepreneuriat.mes-projets')
            ->with('success', 'Votre projet a été soumis avec succès !');
    }

    /**
     * Liste des projets de l'utilisateur connecté
     */
    public function mesProjets()
    {
        $projets = Auth::user()->projetsEntrepreneuriaux()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('entrepreneuriat.mes-projets', compact('projets'));
    }

    /**
     * Détail d'un projet
     */
    public function showProjet(ProjetEntrepreneurial $projet)
    {
        $this->authorize('view', $projet);

        return view('entrepreneuriat.projet-show', compact('projet'));
    }

    /**
     * Afficher le formulaire de création d'une annonce
     */
    public function createAnnonce()
    {
        $secteurs = self::getSecteurs();
        return view('entrepreneuriat.annonce-create', compact('secteurs'));
    }

    /**
     * Publier une nouvelle annonce
     */
    public function storeAnnonce(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:produit,service',
            'secteur' => 'required|string',
            'prix' => 'nullable|numeric|min:0',
        ]);

        $annonce = new Annonce();
        $annonce->user_id = Auth::id();
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->type = $request->type;
        $annonce->secteur = $request->secteur;
        $annonce->prix = $request->prix;
        $annonce->statut = 'actif';
        $annonce->save();

        return redirect()->route('entrepreneuriat.mes-annonces')
            ->with('success', 'Votre annonce a été publiée avec succès !');
    }

    /**
     * Liste des annonces de l'utilisateur connecté
     */
    public function mesAnnonces()
    {
        $annonces = Auth::user()->annonces()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('entrepreneuriat.mes-annonces', compact('annonces'));
    }

    /**
     * Détail d'une annonce
     */
    public function showAnnonce(Annonce $annonce)
    {
        return view('entrepreneuriat.annonce-show', compact('annonce'));
    }

    /**
     * Supprimer une annonce
     */
    public function destroyAnnonce(Annonce $annonce)
    {
        $this->authorize('delete', $annonce);

        $annonce->delete();

        return redirect()->route('entrepreneuriat.mes-annonces')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    /**
     * Modifier le statut d'une annonce (activer/désactiver)
     */
    public function toggleAnnonce(Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        $annonce->statut = $annonce->statut === 'actif' ? 'inactif' : 'actif';
        $annonce->save();

        return redirect()->back()
            ->with('success', 'Statut de l\'annonce mis à jour.');
    }

    /**
     * Voir toutes les annonces publiées
     */
    public function listeAnnonces()
    {
        $annonces = Annonce::with('user')
            ->where('statut', 'actif')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('entrepreneuriat.annonces', compact('annonces'));
    }
}
