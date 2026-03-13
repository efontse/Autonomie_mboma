<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizTentative extends Model
{
    protected $table = 'quiz_tentatives';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'reussie',
        'termine_le',
    ];

    protected $casts = [
        'reussie' => 'boolean',
        'score' => 'integer',
        'termine_le' => 'datetime',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(QuizFormation::class, 'quiz_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reponsesUtilisateurs(): HasMany
    {
        return $this->hasMany(QuizReponseUtilisateur::class, 'tentative_id');
    }
}
