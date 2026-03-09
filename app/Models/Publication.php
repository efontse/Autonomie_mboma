<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    protected $table = 'publications';

    protected $fillable = [
        'user_id', 'titre', 'contenu', 'categorie',
        'statut', 'likes_count', 'comments_count', 'vue',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'vue' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

