<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CommunityPost;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Statistiques communauté
        $communityStats = [
            'posts' => CommunityPost::count(),
            'myPosts' => CommunityPost::where('user_id', $user->id)->count(),
        ];

        // Statistiques notifications
        $notificationsStats = [
            'total' => \App\Models\Notification::where('user_id', $user->id)->count(),
            'unread' => \App\Models\Notification::where('user_id', $user->id)->where('lu', false)->count(),
        ];

        return view('dashboard', compact('user', 'communityStats', 'notificationsStats'));
    }

    /**
     * Profil de l'utilisateur
     */
    public function profil()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
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

        return redirect()->route('profil')->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Modifier le mot de passe
     */
    public function modifierMotDePasse(Request $request)
    {
        $request->validate([
            'mot_de_passe_actuel' => 'required|string',
            'nouveau_mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Vérifier l'ancien mot de passe
        if (!Hash::check($request->mot_de_passe_actuel, $user->password)) {
            return redirect()->route('profil')->with('error', 'Le mot de passe actuel est incorrect.');
        }

        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->nouveau_mot_de_passe);
        $user->save();

        return redirect()->route('profil')->with('success', 'Mot de passe modifié avec succès.');
    }
}
