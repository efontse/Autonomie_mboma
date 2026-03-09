<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InscriptionFormation;


class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'mot_de_passe',
        'role', 'statut', 'photo_profil', 'date_naissance',
        'quartier', 'village', 'bio', 'email_verified_at',
        'derniere_connexion',
    ];

    protected $hidden = ['mot_de_passe', 'remember_token'];

    protected $casts = [
        'email_verified_at'  => 'datetime',
        'derniere_connexion'  => 'datetime',
        'date_naissance'      => 'date',
    ];

    // Utiliser 'mot_de_passe' comme colonne de mot de passe
    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    // ── Relations ──
    public function profil(): HasOne
    {
        return $this->hasOne(Profil::class);
    }


    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class, 'user_id');
    }

    public function projets(): HasMany
    {
        return $this->hasMany(ProjetEntrepreneurial::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // ── Helpers ──
    public function nomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function estModerateur(): bool
    {
        return in_array($this->role, ['admin', 'moderateur']);

    }

    public function formations(): HasMany
    {
        return $this->hasMany(\App\Models\InscriptionFormation::class, 'user_id');
    }

    /**
     * Alias pour inscriptions aux formations
     */
    public function inscriptionsFormations(): HasMany
    {
        return $this->hasMany(InscriptionFormation::class, 'user_id');
    }

    public function notificationsNonLues(): int
    {
        return $this->notifications()->where('lu', false)->count();
    }
}
