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
}

