<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityPost extends Model
{
    protected $table = 'community_posts';

    protected $fillable = [
        'user_id',
        'type',
        'contenu',
        'image',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CommunityReaction::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommunityComment::class, 'post_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'temoignage' => 'Témoignage',
            'conseil' => 'Conseil',
            'demande_aide' => 'Demande d\'aide',
            'celebration' => 'Célébration',
            default => $this->type,
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'temoignage' => '#8B4513',
            'conseil' => '#2D6A4F',
            'demande_aide' => '#C8860A',
            'celebration' => '#D4A853',
            default => '#6B6B6B',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'temoignage' => 'bi-chat-quote',
            'conseil' => 'bi-lightbulb',
            'demande_aide' => 'bi-life-preserver',
            'celebration' => 'bi-balloon',
            default => 'bi-postcard',
        };
    }
}
