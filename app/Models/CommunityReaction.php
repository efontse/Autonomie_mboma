<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityReaction extends Model
{
    protected $table = 'community_reactions';

    protected $fillable = [
        'post_id',
        'user_id',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getEmojiForType(string $type): string
    {
        return match($type) {
            'like' => '👍',
            'love' => '❤️',
            'clap' => '👏',
            'handshake' => '🤝',
            default => '👍',
        };
    }
}
