<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profil;
use App\Models\LogConnexion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─────────────────────────────────────────────────────────
    //  INSCRIPTION
    // ─────────────────────────────────────────────────────────

    /**
     * Afficher le formulaire d'inscription
     */
    public function showInscription()
    {
        return view('auth.inscription');
    }

    /**
     * Traiter l'inscription d'une nouvelle utilisatrice
     */
    public function inscrire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'email'          => 'required|email|max:191|unique:users,email',
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'role'           => 'required|in:femme,jeune_fille,entrepreneur,autre',
            'mot_de_passe'   => [
                'required',
                'confirmed',
                'string',
                'min:8',
            ],
            'cgu'            => 'accepted',
            // Champs profil (étape 3)
            'quartier'            => 'nullable|string|max:100',
            'village'             => 'nullable|string|max:100',
            'niveau_education'    => 'nullable|in:aucun,primaire,secondaire,universitaire,formation_pro',
            'activite_principale' => 'nullable|string|max:200',
        ], [
            'nom.required'          => 'Le nom est obligatoire.',
            'prenom.required'       => 'Le prénom est obligatoire.',
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.unique'         => 'Cette adresse e-mail est déjà utilisée.',
            'email.email'          => 'Adresse e-mail invalide.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.confirmed'=> 'Les mots de passe ne correspondent pas.',
            'mot_de_passe.min'     => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.required'         => 'Veuillez choisir un profil.',
            'cgu.accepted'          => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Création de l'utilisatrice
        $user = User::create([
            'nom'            => ucfirst(strtolower($request->nom)),
            'prenom'         => ucfirst(strtolower($request->prenom)),
            'email'          => strtolower($request->email),
            'telephone'      => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'quartier'       => $request->quartier,
            'village'        => $request->village,
            'role'           => $request->role,
            'mot_de_passe'   => Hash::make($request->mot_de_passe),
            'statut'         => 'actif',
        ]);

        // Création du profil associé
        Profil::create([
            'user_id'             => $user->id,
            'niveau_education'    => $request->niveau_education,
            'activite_principale' => $request->activite_principale,
            'complete'            => 0,
        ]);

        // Log de l'inscription
        $this->logConnexion($user, 'inscription', $request);

        // Connexion automatique après inscription
        Auth::login($user);

        return response()->json([
            'success'  => true,
            'message'  => 'Compte créé avec succès. Bienvenue sur la plateforme Mboma !',
            'redirect' => route('dashboard'),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  CONNEXION
    // ─────────────────────────────────────────────────────────

    /**
     * Afficher la page de connexion
     */
    public function showConnexion()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.connexion');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function connecter(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required|string',
        ], [
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'Adresse e-mail invalide.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
        ]);

        // Chercher l'utilisatrice
        $user = User::where('email', strtolower($request->email))->first();

        // Vérifier les identifiants
        if (!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            $this->logConnexion(null, 'echec', $request, $request->email);
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou mot de passe incorrect.',
            ], 401);
        }

        // Vérifier le statut du compte
        if ($user->statut === 'suspendu') {
            return response()->json([
                'success' => false,
                'message' => 'Votre compte a été suspendu. Contactez l\'administration.',
            ], 403);
        }

        if ($user->statut === 'inactif') {
            return response()->json([
                'success' => false,
                'message' => 'Votre compte est inactif. Veuillez le réactiver.',
            ], 403);
        }

        // Connexion
        $remember = $request->boolean('remember');
        Auth::login($user, $remember);

        // Mise à jour de la dernière connexion
        $user->update(['derniere_connexion' => now()]);

        // Log
        $this->logConnexion($user, 'connexion', $request);

        // Régénérer la session (sécurité)
        $request->session()->regenerate();

        // Rediriger selon le rôle
        $redirect = match ($user->role) {
            'admin', 'moderateur' => route('admin.dashboard'),
            default               => route('dashboard'),
        };

        return response()->json([
            'success'  => true,
            'message'  => 'Connexion réussie. Bon retour, ' . $user->prenom . ' !',
            'redirect' => $redirect,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  DÉCONNEXION
    // ─────────────────────────────────────────────────────────

    public function deconnecter(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->logConnexion($user, 'deconnexion', $request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.connexion')->with('info', 'Vous avez été déconnectée.');
    }

    // ─────────────────────────────────────────────────────────
    //  RÉINITIALISATION MOT DE PASSE
    // ─────────────────────────────────────────────────────────

    public function showResetForm()
    {
        return view('auth.reset-mdp');
    }

    public function envoyerLienReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Aucun compte trouvé avec cette adresse e-mail.',
        ]);

        // Générer un token sécurisé
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // En production : envoyer un e-mail avec le lien
        // Mail::to($request->email)->send(new ResetPasswordMail($token));

        $this->logConnexion(null, 'reset_mdp', $request, $request->email);

        return response()->json([
            'success' => true,
            'message' => 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  HELPER : Journal des connexions
    // ─────────────────────────────────────────────────────────

    private function logConnexion($user, string $action, Request $request, ?string $email = null): void
    {
        LogConnexion::create([
            'user_id'    => $user?->id,
            'email'      => $email ?? $user?->email,
            'action'     => $action,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
