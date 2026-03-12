<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Communauté — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --terre:#8B4513; --savane:#C8860A; --ocre:#D4A853;
      --creme:#FDF6EC; --vert:#2D6A4F; --vert-clair:#52B788;
      --brun-fonce:#3B1F0A; --blanc:#FFFFFF; --gris:#6B6B6B;
      --gris-clair:#F0EAE0;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--creme);
      min-height: 100vh;
    }
    .header {
      background: var(--brun-fonce);
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .header h1 {
      font-family: 'Playfair Display', serif;
      color: var(--blanc);
      font-size: 1.3rem;
    }
    .header a {
      color: var(--ocre);
      text-decoration: none;
      font-size: 0.9rem;
      margin-left: auto;
    }
    .communaute-page {
      max-width: 700px;
      margin: 0 auto;
      padding: 1rem;
    }

    /* Filtres chips */
    .filters {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .chip {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: 1.5px solid var(--gris-clair);
        background: var(--blanc);
        color: var(--gris);
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .chip:hover {
        border-color: var(--vert);
        color: var(--vert);
    }

    .chip.active {
        background: var(--vert);
        color: var(--blanc);
        border-color: var(--vert);
    }

    .chip .badge {
        font-size: 0.7rem;
        padding: 0.15rem 0.4rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.2);
    }

    /* Composer inline */
    .composer {
        background: var(--blanc);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .composer-type-selector {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .type-option {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        border: 1.5px solid var(--gris-clair);
        background: var(--blanc);
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .type-option:hover {
        border-color: var(--vert);
    }

    .type-option.selected {
        border-color: var(--vert);
        background: rgba(45, 106, 79, 0.1);
        color: var(--vert);
        font-weight: 600;
    }

    .type-option[data-type="temoignage"] { border-left: 3px solid #8B4513; }
    .type-option[data-type="conseil"] { border-left: 3px solid #2D6A4F; }
    .type-option[data-type="demande_aide"] { border-left: 3px solid #C8860A; }
    .type-option[data-type="celebration"] { border-left: 3px solid #D4A853; }

    .composer textarea {
        width: 100%;
        border: 1.5px solid var(--gris-clair);
        border-radius: 8px;
        padding: 0.75rem;
        font-family: inherit;
        font-size: 0.9rem;
        resize: none;
        min-height: 80px;
        outline: none;
        transition: border-color 0.2s;
    }

    .composer textarea:focus {
        border-color: var(--vert);
    }

    .composer-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
    }

    .composer-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .composer-actions label {
        cursor: pointer;
        color: var(--vert);
        font-size: 1.2rem;
    }

    .char-count {
        font-size: 0.75rem;
        color: var(--gris);
    }

    .char-count.warning { color: #C8860A; }
    .char-count.danger { color: #C0392B; }

    .btn-post {
        background: var(--vert);
        color: var(--blanc);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-post:hover {
        background: #1a5c3a;
    }

    .btn-post:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Post card */
    .post-card {
        background: var(--blanc);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .post-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .post-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--savane), var(--ocre));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blanc);
        font-weight: 600;
    }

    .post-meta {
        flex: 1;
    }

    .post-author {
        font-weight: 600;
        color: var(--brun-fonce);
        font-size: 0.9rem;
    }

    .post-date {
        font-size: 0.75rem;
        color: var(--gris);
    }

    .post-type-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .post-type-badge.temoignage { background: rgba(139,69,19,0.1); color: #8B4513; }
    .post-type-badge.conseil { background: rgba(45,106,79,0.1); color: #2D6A4F; }
    .post-type-badge.demande_aide { background: rgba(200,134,10,0.1); color: #C8860A; }
    .post-type-badge.celebration { background: rgba(212,168,83,0.1); color: #B8860B; }

    .post-content {
        color: var(--brun-fonce);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .post-image {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }

    /* Reactions */
    .post-reactions {
        display: flex;
        gap: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--gris-clair);
    }

    .reaction-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.3rem 0.5rem;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .reaction-btn:hover {
        background: var(--gris-clair);
    }

    .reaction-btn.active {
        background: rgba(45,106,79,0.1);
    }

    .reaction-count {
        font-size: 0.8rem;
        color: var(--gris);
        margin-left: 0.3rem;
    }

    /* Comments */
    .comments-section {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--gris-clair);
    }

    .comment-toggle {
        background: none;
        border: none;
        color: var(--vert);
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .comment-form {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .comment-form input {
        flex: 1;
        border: 1px solid var(--gris-clair);
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        outline: none;
    }

    .comment-form input:focus {
        border-color: var(--vert);
    }

    .comment-form button {
        background: var(--vert);
        color: var(--blanc);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .comment {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .comment-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--gris-clair);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--gris);
    }

    .comment-body {
        flex: 1;
        background: var(--gris-clair);
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
    }

    .comment-author {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--brun-fonce);
    }

    .comment-content {
        font-size: 0.85rem;
        color: var(--brun-fonce);
    }

    .comment-date {
        font-size: 0.7rem;
        color: var(--gris);
        margin-top: 0.2rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--gris);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--gris-clair);
    }
</style>
</head>
<body>
<div class="header">
  <i class="bi bi-people" style="color: var(--ocre); font-size: 1.5rem;"></i>
  <h1>Communauté Mboma</h1>
  <a href="{{ route('dashboard') }}"><i class="bi bi-arrow-left"></i> Retour au tableau de bord</a>
</div>

<div class="communaute-page">
    <h1 style="font-size: 1.5rem; color: var(--brun-fonce); margin-bottom: 1.5rem;">
        <i class="bi bi-people"></i> Communauté Mboma
    </h1>

    <!-- Filtres -->
    <div class="filters">
        <a href="{{ route('communaute.index') }}" class="chip {{ !$type ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Tout
        </a>
        <a href="{{ route('communaute.index', ['type' => 'temoignage']) }}" class="chip {{ $type == 'temoignage' ? 'active' : '' }}">
            <i class="bi bi-chat-quote"></i> Témoignage
        </a>
        <a href="{{ route('communaute.index', ['type' => 'conseil']) }}" class="chip {{ $type == 'conseil' ? 'active' : '' }}">
            <i class="bi bi-lightbulb"></i> Conseil
        </a>
        <a href="{{ route('communaute.index', ['type' => 'demande_aide']) }}" class="chip {{ $type == 'demande_aide' ? 'active' : '' }}">
            <i class="bi bi-life-preserver"></i> Demande d'aide
        </a>
        <a href="{{ route('communaute.index', ['type' => 'celebration']) }}" class="chip {{ $type == 'celebration' ? 'active' : '' }}">
            <i class="bi bi-balloon"></i> Célébration
        </a>
    </div>

    <!-- Composer -->
    <div class="composer">
        <div class="composer-type-selector">
            <div class="type-option selected" data-type="temoignage">
                <i class="bi bi-chat-quote"></i> Témoignage
            </div>
            <div class="type-option" data-type="conseil">
                <i class="bi bi-lightbulb"></i> Conseil
            </div>
            <div class="type-option" data-type="demande_aide">
                <i class="bi bi-life-preserver"></i> Demande d'aide
            </div>
            <div class="type-option" data-type="celebration">
                <i class="bi bi-balloon"></i> Célébration
            </div>
        </div>

        <form id="composer-form">
            @csrf
            <input type="hidden" name="type" id="post-type" value="temoignage">
            <textarea
                id="post-content"
                name="contenu"
                placeholder="Partagez avec la communauté..."
                maxlength="1000"
            ></textarea>

            <div class="composer-footer">
                <div class="composer-actions">
                    <label for="post-image">
                        <i class="bi bi-camera"></i>
                    </label>
                    <input type="file" id="post-image" name="image" accept="image/*" style="display: none;">
                    <span class="char-count" id="char-count">0/1000</span>
                </div>
                <button type="submit" class="btn-post" id="btn-post">
                    <i class="bi bi-send"></i> Publier
                </button>
            </div>
        </form>
    </div>

    <!-- Fil d'actualité -->
    <div id="posts-container">
        @forelse($posts as $post)
            @include('communaute.partials.post', ['post' => $post])
        @empty
            <div class="empty-state">
                <i class="bi bi-chat-dots"></i>
                <p>Aucun post dans la communauté.<br>Soyez le premier à publier !</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modale de signalement -->
<div id="report-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:1.5rem; max-width:400px; width:90%;">
        <h3 style="margin-bottom:1rem; color:var(--brun-fonce);"><i class="bi bi-flag"></i> Signaler ce post</h3>
        <form id="report-form">
            @csrf
            <input type="hidden" id="report-post-id" name="post_id">

            <div style="margin-bottom:1rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Motif :</label>
                <select name="motif" id="report-motif" required style="width:100%; padding:0.5rem; border:1px solid var(--gris-clair); border-radius:8px;">
                    <option value="">Sélectionner...</option>
                    <option value="spam">Spam</option>
                    <option value="harcelement">Harcèlement</option>
                    <option value="contenu_inapproprié">Contenu inapproprié</option>
                    <option value="fausse_information">Fausse information</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Détails (optionnel) :</label>
                <textarea name="details" id="report-details" rows="3" placeholder="Précisez..." style="width:100%; padding:0.5rem; border:1px solid var(--gris-clair); border-radius:8px; resize:none;"></textarea>
            </div>

            <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                <button type="button" onclick="closeReportModal()" style="padding:0.5rem 1rem; border:1px solid var(--gris-clair); border-radius:8px; background:white; cursor:pointer;">Annuler</button>
                <button type="submit" style="padding:0.5rem 1rem; border:none; border-radius:8px; background:var(--erreur,#C0392B); color:white; cursor:pointer;">Signaler</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Type selector
    document.querySelectorAll('.type-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.type-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('post-type').value = this.dataset.type;
        });
    });

    // Character count
    const textarea = document.getElementById('post-content');
    const charCount = document.getElementById('char-count');

    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length}/1000`;
        charCount.className = 'char-count';
        if (length > 900) charCount.classList.add('warning');
        if (length > 980) charCount.classList.add('danger');
    });

    // Submit post
    document.getElementById('composer-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('btn-post');
        const formData = new FormData(this);

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Publication...';

        try {
            const response = await fetch('{{ route("communaute.posts.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                textarea.value = '';
                charCount.textContent = '0/1000';
                document.getElementById('post-image').value = '';

                // Reload posts
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la publication');
            }
        } catch (error) {
            alert('Erreur réseau');
        }

        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send"></i> Publier';
    });

    // Toggle reaction
    async function toggleReaction(postId, type) {
        try {
            const response = await fetch('{{ route("communaute.reactions.toggle") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ post_id: postId, type: type })
            });

            const data = await response.json();

            if (data.success) {
                // Update UI
                const btn = document.querySelector(`[data-post="${postId}"][data-type="${type}"]`);
                const countSpan = btn.querySelector('.reaction-count');

                if (data.action === 'added') {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }

                // Update counts
                document.querySelectorAll(`[data-post="${postId}"].reaction-btn`).forEach(b => {
                    const t = b.dataset.type;
                    const count = data.reactions[t] || 0;
                    const countEl = b.querySelector('.reaction-count');
                    if (countEl) countEl.textContent = count;
                });
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    // Toggle comments
    async function toggleComments(postId) {
        const section = document.getElementById(`comments-${postId}`);
        const isHidden = section.style.display === 'none';

        if (isHidden) {
            // Load comments if not loaded
            if (!section.dataset.loaded) {
                try {
                    const response = await fetch(`/communaute/comments/${postId}`);
                    const data = await response.json();

                    if (data.success) {
                        renderComments(postId, data.comments);
                        section.dataset.loaded = 'true';
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                }
            }
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }

    function renderComments(postId, comments) {
        const section = document.getElementById(`comments-${postId}`);
        section.innerHTML = comments.map(c => `
            <div class="comment">
                <div class="comment-avatar">${c.user.prenom ? c.user.prenom.charAt(0) : 'U'}</div>
                <div class="comment-body">
                    <div class="comment-author">${c.user.prenom || 'Utilisateur'}</div>
                    <div class="comment-content">${c.contenu}</div>
                    <div class="comment-date">${new Date(c.created_at).toLocaleDateString('fr-FR')}</div>
                </div>
            </div>
        `).join('');
    }

    // Submit comment
    async function submitComment(postId) {
        const input = document.getElementById(`comment-input-${postId}`);
        const contenu = input.value.trim();

        if (!contenu) return;

        try {
            const response = await fetch('{{ route("communaute.comments.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ post_id: postId, contenu: contenu })
            });

            const data = await response.json();

            if (data.success) {
                input.value = '';

                // Add new comment to list
                const section = document.getElementById(`comments-${postId}`);
                if (!section.dataset.loaded) {
                    section.dataset.loaded = 'true';
                    section.innerHTML = '';
                }

                const commentHtml = `
                    <div class="comment">
                        <div class="comment-avatar">${data.comment.user.prenom ? data.comment.user.prenom.charAt(0) : 'U'}</div>
                        <div class="comment-body">
                            <div class="comment-author">${data.comment.user.prenom || 'Utilisateur'}</div>
                            <div class="comment-content">${data.comment.contenu}</div>
                            <div class="comment-date">À l'instant</div>
                        </div>
                    </div>
                `;
                section.insertAdjacentHTML('beforeend', commentHtml);

                // Update count
                const countBtn = document.querySelector(`[onclick="toggleComments(${postId})"]`);
                const currentCount = parseInt(countBtn.textContent.match(/\d+/)[0] || 0);
                countBtn.innerHTML = `<i class="bi bi-chat"></i> ${currentCount + 1} commentaire(s)`;
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }
</script>
</div>

<script>
    const CSRF_TOKEN = '{{ csrf_token() }}';
    const REACTION_ROUTE = '{{ route("communaute.reactions.toggle") }}';
    const COMMENT_ROUTE = '{{ route("communaute.comments.store") }}';
    const REPORT_ROUTE = '{{ route("communaute.report") }}';

    // Ouvrir la modale de signalement
    function openReportModal(postId) {
        document.getElementById('report-post-id').value = postId;
        document.getElementById('report-modal').style.display = 'flex';
    }

    // Fermer la modale
    function closeReportModal() {
        document.getElementById('report-modal').style.display = 'none';
        document.getElementById('report-form').reset();
    }

    // Soumettre le signalement
    document.getElementById('report-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch(REPORT_ROUTE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                closeReportModal();
            } else {
                alert(data.message || 'Erreur lors du signalement');
            }
        } catch (error) {
            alert('Erreur réseau');
        }
    });

    // Fermer la modale en cliquant à l'extérieur
    document.getElementById('report-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReportModal();
        }
    });
</script>
</body>
</html>
