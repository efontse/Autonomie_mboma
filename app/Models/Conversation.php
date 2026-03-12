<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = [
        'dernier_message_id',
    ];

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('dernier_lu')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function dernierMessage()
    {
        return $this->belongsTo(Message::class, 'dernier_message_id');
    }

    public function getOtherParticipant($userId)
    {
        return $this->participants()
            ->where('user_id', '!=', $userId)
            ->first();
    }

    public function getUnreadCount($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        if (!$participant) return 0;

        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('created_at', '>', $participant->pivot->dernier_lu ?? $this->created_at)
            ->count();
    }
}
