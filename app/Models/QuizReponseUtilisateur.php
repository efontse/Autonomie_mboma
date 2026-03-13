<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizReponseUtilisateur extends Model
{
    protected $table = 'quiz_reponses_utilisateurs';

    protected $fillable = [
        'tentative_id',
        'question_id',
        'reponse_id',
    ];

    public function tentative(): BelongsTo
    {
        return $this->belongsTo(QuizTentative::class, 'tentative_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function reponse(): BelongsTo
    {
        return $this->belongsTo(QuizReponse::class, 'reponse_id');
    }
}
