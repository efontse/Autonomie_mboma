<?php
// ============================================================
// app/Http/Controllers/InformationController.php
// Controller pour la gestion des informations
// ============================================================

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    /**
     * Affiche la liste de toutes les informations publiées
     */
    public function index()
    {
        $informations = Information::with('auteur')
            ->publie()
            ->latest()
            ->get();

        return view('informations.index', compact('informations'));
    }

    /**
     * Affiche une information spécifique
     */
    public function show(int $id)
    {
        $information = Information::with(['auteur', 'commentairesApprouves'])
            ->findOrFail($id);

        // Incrémenter le nombre de vues
        $information->incrementerVues();

        return view('informations.show', compact('information'));
    }

    /**
     * Affiche le formulaire de création d'une information
     */
    public function create()
    {
        $categories = Information::categories();
        return view('informations.create', compact('categories'));
    }

    /**
     * Enregistre une nouvelle information
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie' => 'required|string|in:' . implode(',', array_keys(Information::categories())),
            'image_url' => 'nullable|url',
        ]);

        $information = Information::create([
            'auteur_id' => Auth::id(),
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
            'categorie' => $validated['categorie'],
            'image_url' => $validated['image_url'] ?? null,
            'statut' => 'publie',
            'vues' => 0,
        ]);

        return redirect()->route('informations.index')
            ->with('success', 'Information créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'une information
     */
    public function edit(int $id)
    {
        $information = Information::findOrFail($id);

        // Vérifier que l'utilisateur est l'auteur ou admin
        if ($information->auteur_id !== Auth::id() && !Auth::user()->estAdmin()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette information.');
        }

        $categories = Information::categories();
        return view('informations.edit', compact('information', 'categories'));
    }

    /**
     * Met à jour une information existante
     */
    public function update(Request $request, int $id)
    {
        $information = Information::findOrFail($id);

        // Vérifier que l'utilisateur est l'auteur ou admin
        if ($information->auteur_id !== Auth::id() && !Auth::user()->estAdmin()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette information.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie' => 'required|string|in:' . implode(',', array_keys(Information::categories())),
            'image_url' => 'nullable|url',
        ]);

        $information->update($validated);

        return redirect()->route('informations.show', $information->id)
            ->with('success', 'Information mise à jour avec succès.');
    }

    /**
     * Supprime une information
     */
    public function destroy(int $id)
    {
        $information = Information::findOrFail($id);

        // Vérifier que l'utilisateur est l'auteur ou admin
        if ($information->auteur_id !== Auth::id() && !Auth::user()->estAdmin()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette information.');
        }

        $information->delete();

        return redirect()->route('informations.index')
            ->with('success', 'Information supprimée avec succès.');
    }
}
