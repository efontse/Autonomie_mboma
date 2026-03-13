<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizFormation extends Model
{
    protected $table = 'quiz_formations';

    protected $fillable = [
        'formation_id',
        'titre',
        'description',
        'score_minimum',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'score_minimum' => 'integer',
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id')->orderBy('ordre');
    }

    public function tentatives(): HasMany
    {
        return $this->hasMany(QuizTentative::class, 'quiz_id');
    }

    /**
     * Vérifie si un utilisateur a réussi ce quiz
     */
    public function aReussi(int $userId): bool
    {
        return $this->tentatives()
            ->where('user_id', $userId)
            ->where('reussie', true)
            ->exists();
    }

    /**
     * Récupère la meilleure tentative d'un utilisateur
     */
    public function meilleureTentative(int $userId)
    {
        return $this->tentatives()
            ->where('user_id', $userId)
            ->orderBy('score', 'desc')
            ->first();
    }
}
