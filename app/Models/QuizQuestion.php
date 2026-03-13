<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'ordre',
    ];

    protected $casts = [
        'ordre' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(QuizFormation::class, 'quiz_id');
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(QuizReponse::class, 'question_id')->orderBy('ordre');
    }

    /**
     * Récupère les réponses correctes
     */
    public function reponsesCorrectes()
    {
        return $this->reponses()->where('est_correcte', true);
    }
}
