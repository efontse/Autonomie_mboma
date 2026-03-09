<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetEntrepreneurial extends Model
{
    protected $table = 'projet_entrepreneurials';

    protected $fillable = [
        'user_id', 'titre', 'description', 'secteur',
        'budget', 'statut', 'date_soumission',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'date_soumission' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

