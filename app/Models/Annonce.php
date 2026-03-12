<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    protected $table = 'annonces';

    protected $fillable = [
        'user_id', 'titre', 'description', 'type',
        'secteur', 'prix', 'statut',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
