<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\CommunityReaction;
use App\Models\CommunityComment;
use App\Models\CommunityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunauteController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');

        $query = CommunityPost::with(['user', 'reactions', 'comments.user'])
            ->orderBy('created_at', 'desc');

        if ($type && in_array($type, ['temoignage', 'conseil', 'demande_aide', 'celebration'])) {
            $query->where('type', $type);
        }

        $posts = $query->get();

        return view('communaute.index', compact('posts', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:temoignage,conseil,demande_aide,celebration',
            'contenu' => 'required|string|min:1|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community', 'public');
        }

        $post = CommunityPost::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'contenu' => $request->contenu,
            'image' => $imagePath,
        ]);

        $post->load(['user', 'reactions', 'comments.user']);

        return response()->json([
            'success' => true,
            'message' => 'Post créé avec succès',
            'post' => $post,
        ]);
    }

    public function toggleReaction(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:community_posts,id',
            'type' => 'required|in:like,love,clap,handshake',
        ]);

        $userId = Auth::id();
        $postId = $request->post_id;
        $type = $request->type;

        $existingReaction = CommunityReaction::where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('type', $type)
            ->first();

        $post = CommunityPost::find($postId);

        if ($existingReaction) {
            $existingReaction->delete();
            $post->decrement('likes_count');
            $action = 'removed';
        } else {
            CommunityReaction::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'type' => $type,
            ]);
            $post->increment('likes_count');
            $action = 'added';
        }

        $reactions = CommunityReaction::where('post_id', $postId)
            ->select('type')
            ->get()
            ->groupBy('type')
            ->map(fn($items) => $items->count());

        $userReactions = CommunityReaction::where('post_id', $postId)
            ->where('user_id', $userId)
            ->pluck('type')
            ->toArray();

        return response()->json([
            'success' => true,
            'action' => $action,
            'reactions' => $reactions,
            'userReactions' => $userReactions,
            'total' => $post->fresh()->likes_count,
        ]);
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:community_posts,id',
            'contenu' => 'required|string|min:1|max:500',
        ]);

        $comment = CommunityComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'contenu' => $request->contenu,
        ]);

        $post = CommunityPost::find($request->post_id);
        $post->increment('comments_count');

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Commentaire ajouté',
            'comment' => $comment,
        ]);
    }

    public function getComments($postId)
    {
        $comments = CommunityComment::with('user')
            ->where('post_id', $postId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments,
        ]);
    }

    public function report(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:community_posts,id',
            'motif' => 'required|in:spam,harcelement,contenu_inapproprie,fausse_information,autre',
            'details' => 'nullable|string|max:500',
        ]);

        $existing = CommunityReport::where('post_id', $request->post_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà signalé ce post',
            ]);
        }

        CommunityReport::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'motif' => $request->motif,
            'details' => $request->details,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Signalement enregistré. Merci !',
        ]);
    }
}
