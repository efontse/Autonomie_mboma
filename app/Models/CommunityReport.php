<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityReport extends Model
{
    protected $table = 'community_reports';

    protected $fillable = [
        'post_id',
        'user_id',
        'motif',
        'details',
        'statut',
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

    public static function getMotifLabel(string $motif): string
    {
        return match($motif) {
            'spam' => 'Spam',
            'harcelement' => 'Harcèlement',
            'contenu_inapproprié' => 'Contenu inapproprié',
            'fausse_information' => 'Fausse information',
            'autre' => 'Autre',
            default => $motif,
        };
    }
}
