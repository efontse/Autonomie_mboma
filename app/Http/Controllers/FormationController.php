<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\InscriptionFormation;
use App\Models\CategorieFormation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    /**
     * Liste des formations publiées
     */
    public function index()
    {
        $formations = Formation::with(['categorie', 'auteur'])
            ->where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('formation.formation_index', compact('formations'));
    }

    /**
     * Liste des formations auxquelles l'utilisateur est inscrit
     */
    public function mesFormations()
    {
        $inscriptions = Auth::user()->inscriptionsFormations()
            ->with(['formation.categorie', 'formation.auteur'])
            ->orderBy('inscrit_le', 'desc')
            ->get();

        return view('formation.formation_mes-formations', compact('inscriptions'));
    }

    /**
     * Détail d'une formation
     */
    public function show(Formation $formation)
    {
        // Incrémenter le compteur de vues
        $formation->increment('vues');

        $formation->load(['categorie', 'auteur', 'inscriptions.user']);

        return view('formation.formation_show', compact('formation'));
    }

    /**
     * S'inscrire à une formation
     */
    public function inscrire(Request $request, Formation $formation)
    {
        $user = Auth::user();

        // Vérifier si déjà inscrit
        $inscriptionExistante = $user->inscriptionsFormations()
            ->where('formation_id', $formation->id)
            ->first();

        if ($inscriptionExistante) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Vous êtes déjà inscrit à cette formation.']);
            }
            return redirect()->back()->with('info', 'Vous êtes déjà inscrit à cette formation.');
        }

        // Créer l'inscription
        InscriptionFormation::create([
            'user_id' => $user->id,
            'formation_id' => $formation->id,
            'progression' => 0,
            'termine' => false,
            'inscrit_le' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Inscription réussie ! Vous pouvez maintenant suivre cette formation.']);
        }
        return redirect()->back()->with('success', 'Inscription réussie ! Vous pouvez maintenant suivre cette formation.');
    }

    /**
     * Mettre à jour la progression (AJAX)
     */
    public function progression(Request $request, Formation $formation)
    {
        $request->validate([
            'progression' => 'required|integer|min:0|max:100',
        ]);

        $inscription = Auth::user()->inscriptionsFormations()
            ->where('formation_id', $formation->id)
            ->first();

        if (!$inscription) {
            return response()->json(['error' => 'Vous n\'êtes pas inscrit à cette formation.'], 404);
        }

        $inscription->update([
            'progression' => $request->progression,
        ]);

        return response()->json(['success' => true, 'progression' => $inscription->progression]);
    }

    // ── Routes admin ─────────────────────────────────────────────

    /**
     * Liste des formations (admin)
     */
    public function adminIndex()
    {
        $formations = Formation::with(['categorie', 'auteur', 'inscriptions'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('formation.formation_admin_index', compact('formations'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $categories = CategorieFormation::orderBy('nom')->get();
        return view('formation.formation_admin_form', compact('categories'));
    }

    /**
     * Enregistrer une nouvelle formation
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categorie_formations,id',
            'type' => 'required|in:video,texte,document',
            'niveau' => 'required|in:debutant,intermediaire,avance',
            'duree_minutes' => 'required|integer|min:1',
            'video_url' => 'nullable|url',
            'document_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        $formation = Formation::create([
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

        return redirect()->route('formation.admin.show', $formation->id)
            ->with('success', 'Formation créée avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Formation $formation)
    {
        $categories = CategorieFormation::orderBy('nom')->get();
        return view('formation.formation_admin_form', compact('formation', 'categories'));
    }

    /**
     * Mettre à jour une formation
     */
    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categorie_formations,id',
            'type' => 'required|in:video,texte,document',
            'niveau' => 'required|in:debutant,intermediaire,avance',
            'duree_minutes' => 'required|integer|min:1',
            'video_url' => 'nullable|url',
            'document_url' => 'nullable|url',
            'image_url' => 'nullable|url',
            'statut' => 'required|in:brouillon,publie,archive',
        ]);

        $formation->update($request->all());

        return redirect()->route('formation.admin.show', $formation->id)
            ->with('success', 'Formation mise à jour avec succès !');
    }

    /**
     * Supprimer une formation
     */
    public function destroy(Formation $formation)
    {
        // Supprimer les inscriptions associées
        $formation->inscriptions()->delete();

        // Supprimer la formation
        $formation->delete();

        return redirect()->route('formation.admin.index')
            ->with('success', 'Formation supprimée avec succès !');
    }
}
