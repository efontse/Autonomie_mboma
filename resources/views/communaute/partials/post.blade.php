<div class="post-card" id="post-{{ $post->id }}">
    <div class="post-header">
        <div class="post-avatar">
            {{ $post->user->prenom ? $post->user->prenom[0] : 'U' }}
        </div>
        <div class="post-meta">
            <div class="post-author">{{ $post->user->prenom ?? 'Utilisateur' }} {{ $post->user->nom ?? '' }}</div>
            <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
        </div>
        <div class="post-type-badge {{ $post->type }}">
            <i class="bi bi-{{ $post->type_icon }}"></i>
            {{ $post->type_label }}
        </div>
    </div>

    <div class="post-content">
        {{ $post->contenu }}
    </div>

    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Image du post" class="post-image">
    @endif

    <div class="post-reactions">
        <button class="reaction-btn {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) && $post->reactions->where('user_id', auth()->id())->first()->type === 'like' ? 'active' : '' }}"
                data-post="{{ $post->id }}" data-type="like"
                onclick="toggleReaction({{ $post->id }}, 'like')">
            👍<span class="reaction-count">{{ $post->reactions->where('type', 'like')->count() }}</span>
        </button>
        <button class="reaction-btn {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) && $post->reactions->where('user_id', auth()->id())->first()->type === 'love' ? 'active' : '' }}"
                data-post="{{ $post->id }}" data-type="love"
                onclick="toggleReaction({{ $post->id }}, 'love')">
            ❤️<span class="reaction-count">{{ $post->reactions->where('type', 'love')->count() }}</span>
        </button>
        <button class="reaction-btn {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) && $post->reactions->where('user_id', auth()->id())->first()->type === 'clap' ? 'active' : '' }}"
                data-post="{{ $post->id }}" data-type="clap"
                onclick="toggleReaction({{ $post->id }}, 'clap')">
            👏<span class="reaction-count">{{ $post->reactions->where('type', 'clap')->count() }}</span>
        </button>
        <button class="reaction-btn {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) && $post->reactions->where('user_id', auth()->id())->first()->type === 'handshake' ? 'active' : '' }}"
                data-post="{{ $post->id }}" data-type="handshake"
                onclick="toggleReaction({{ $post->id }}, 'handshake')">
            🤝<span class="reaction-count">{{ $post->reactions->where('type', 'handshake')->count() }}</span>
        </button>
    </div>

    <div class="comments-section">
        <button class="comment-toggle" onclick="toggleComments({{ $post->id }})">
            <i class="bi bi-chat"></i> {{ $post->comments_count }} commentaire(s)
        </button>

        <div class="comment-form">
            <input type="text" id="comment-input-{{ $post->id }}" placeholder="Écrire un commentaire..." maxlength="500">
            <button onclick="submitComment({{ $post->id }})">Envoyer</button>
        </div>

        <div id="comments-{{ $post->id }}" style="display: none;">
            @foreach($post->comments->take(2) as $comment)
                <div class="comment">
                    <div class="comment-avatar">{{ $comment->user->prenom ? $comment->user->prenom[0] : 'U' }}</div>
                    <div class="comment-body">
                        <div class="comment-author">{{ $comment->user->prenom ?? 'Utilisateur' }}</div>
                        <div class="comment-content">{{ $comment->contenu }}</div>
                        <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
            @if($post->comments_count > 2)
                <button class="comment-toggle" style="margin-top: 0.5rem; font-size: 0.8rem;" onclick="loadMoreComments({{ $post->id }})">
                    Voir les {{ $post->comments_count - 2 }} autres commentaires
                </button>
            @endif
        </div>
    </div>
</div>
