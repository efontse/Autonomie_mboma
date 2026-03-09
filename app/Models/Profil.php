<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profil extends Model
{
    protected $table = 'profils';

    protected $fillable = [
        'user_id', 'niveau_education', 'situation_matrimoniale',
        'nombre_enfants', 'activite_principale', 'competences',
        'centres_interet', 'langue_parlee', 'besoins_specifiques', 'complete',
    ];

    protected $casts = [
        'complete' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pourcentageCompletude(): int
    {
        $champs = [
            'niveau_education', 'situation_matrimoniale',
            'activite_principale', 'competences', 'centres_interet',
        ];
        $remplis = collect($champs)->filter(fn($c) => !empty($this->$c))->count();
        return (int) (($remplis / count($champs)) * 100);
    }
}

