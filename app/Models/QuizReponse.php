<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizReponse extends Model
{
    protected $table = 'quiz_reponses';

    protected $fillable = [
        'question_id',
        'reponse',
        'est_correcte',
        'ordre',
    ];

    protected $casts = [
        'est_correcte' => 'boolean',
        'ordre' => 'integer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
