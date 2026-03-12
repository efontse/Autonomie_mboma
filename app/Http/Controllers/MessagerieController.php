<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['participants', 'dernierMessage', 'messages' => function($q) use ($userId) {
            $q->where('user_id', '!=', $userId)->where('est_lu', false);
        }])
        ->get()
        ->map(function($conv) use ($userId) {
            $conv->autre = $conv->getOtherParticipant($userId);
            $conv->non_lus = $conv->getUnreadCount($userId);
            return $conv;
        })
        ->sortByDesc('dernierMessage.created_at');

        return view('messagerie.index', compact('conversations'));
    }

    public function show($id)
    {
        $userId = Auth::id();

        $conversation = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['participants', 'messages.user'])
        ->findOrFail($id);

        // Marquer les messages comme lus
        $conversation->messages()
            ->where('user_id', '!=', $userId)
            ->where('est_lu', false)
            ->update(['est_lu' => true]);

        // Mettre à jour le pivot dernier_lu
        $conversation->participants()->updateExistingPivot($userId, [
            'dernier_lu' => now()
        ]);

        $conversation->autre = $conversation->getOtherParticipant($userId);

        return view('messagerie.show', compact('conversation'));
    }

    public function getConversations(Request $request)
    {
        $userId = Auth::id();

        $conversations = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['participants', 'dernierMessage'])
        ->get()
        ->map(function($conv) use ($userId) {
            $conv->autre = $conv->getOtherParticipant($userId);
            $conv->non_lus = $conv->getUnreadCount($userId);
            return $conv;
        })
        ->sortByDesc('dernierMessage.created_at');

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    public function getUnreadCount()
    {
        $userId = Auth::id();

        $total = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get()
        ->sum(function($conv) use ($userId) {
            return $conv->getUnreadCount($userId);
        });

        return response()->json([
            'success' => true,
            'unread' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'contenu' => 'required|string|max:2000',
        ]);

        $userId = Auth::id();
        $autreId = $request->user_id;

        // Chercher ou créer une conversation existante
        $conversation = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->whereHas('participants', function($query) use ($autreId) {
            $query->where('user_id', $autreId);
        })
        ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->attach([$userId, $autreId]);
        }

        // Créer le message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'contenu' => $request->contenu,
        ]);

        // Mettre à jour le dernier message
        $conversation->update(['dernier_message_id' => $message->id]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'conversation_id' => $conversation->id,
        ]);
    }

    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        $userId = Auth::id();

        $conversation = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->findOrFail($conversationId);

        // Créer le message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'contenu' => $request->contenu,
        ]);

        // Mettre à jour le dernier message
        $conversation->update(['dernier_message_id' => $message->id]);

        $message->load('user');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function getMessages($conversationId)
    {
        $userId = Auth::id();

        $conversation = Conversation::whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['messages.user'])
        ->findOrFail($conversationId);

        return response()->json([
            'success' => true,
            'messages' => $conversation->messages,
        ]);
    }

    public function startConversation($userId)
    {
        $currentUserId = Auth::id();

        // Chercher ou créer une conversation existante
        $conversation = Conversation::whereHas('participants', function($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
        ->whereHas('participants', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->attach([$currentUserId, $userId]);
        }

        return redirect()->route('messagerie.show', $conversation->id);
    }
}
