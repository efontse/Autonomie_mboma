<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InscriptionFormation extends Model
{
    protected $table = 'inscriptions_formations';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'formation_id',
        'progression',
        'termine',
        'certificat_url',
        'inscrit_le',
        'termine_le',
    ];

    protected $casts = [
        'termine' => 'boolean',
        'progression' => 'integer',
        'inscrit_le' => 'datetime',
        'termine_le' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }
}

