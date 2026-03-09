<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    protected $table = 'formations';

    protected $fillable = [
        'categorie_id',
        'auteur_id',
        'titre',
        'description',
        'contenu',
        'type',
        'video_url',
        'document_url',
        'image_url',
        'duree_minutes',
        'niveau',
        'statut',
        'vues',
    ];

    protected $casts = [
        'duree_minutes' => 'integer',
        'vues' => 'integer',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieFormation::class);
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(InscriptionFormation::class);
    }

    /**
     * Retourne la durée formatée (ex: 2h 30min)
     */
    public function dureeFormatee(): string
    {
        if (!$this->duree_minutes) {
            return '';
        }

        $heures = intdiv($this->duree_minutes, 60);
        $minutes = $this->duree_minutes % 60;

        if ($heures > 0 && $minutes > 0) {
            return $heures . 'h ' . $minutes . 'min';
        } elseif ($heures > 0) {
            return $heures . 'h';
        } else {
            return $minutes . 'min';
        }
    }
}

