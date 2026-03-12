<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $information->titre }} — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0;
      --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68;
      --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --sidebar-w:280px;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }

    /* ── Sidebar ── */
    .sidebar {
      width: 280px;
      background: var(--blanc);
      border-right: 1px solid var(--gris-clair);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
      transition: transform 0.3s ease;
    }
    .sidebar-logo {
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-bottom: 1px solid var(--gris-clair);
    }
    .logo-mark {
      width: 40px; height: 40px;
      background: #F0D9B5;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
    }
    .logo-text { display: flex; flex-direction: column; }
    .logo-name { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--brun); }
    .logo-sub { font-size: 0.7rem; color: var(--gris); text-transform: uppercase; letter-spacing: 0.1em; }

    .sidebar-profil {
      padding: 1.25rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-bottom: 1px solid var(--gris-clair);
    }
    .avatar {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2A6049, #3D8A68);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 700;
      color: var(--blanc);
      position: relative;
    }
    .avatar-status {
      position: absolute; bottom: 0; right: 0;
      width: 12px; height: 12px;
      background: #3D8A68;
      border-radius: 50%;
      border: 2px solid var(--blanc);
    }
    .profil-info { flex: 1; min-width: 0; }
    .profil-nom { font-weight: 600; font-size: 0.9rem; color: var(--texte); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .profil-role { font-size: 0.75rem; color: var(--gris); }

    .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
    .nav-section-label {
      padding: 0.5rem 1.5rem;
      font-size: 0.65rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--gris);
    }
    .nav-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1.5rem;
      color: var(--texte-doux);
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 500;
      transition: all 0.2s;
      border-left: 3px solid transparent;
    }
    .nav-item:hover { background: var(--ivoire); color: var(--texte); }
    .nav-item.actif { background: var(--ivoire); color: var(--brun); border-left-color: var(--or); }
    .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

    .sidebar-footer { padding: 1rem; border-top: 1px solid var(--gris-clair); }
    .btn-deconnexion {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.75rem;
      background: transparent;
      border: 1px solid var(--gris-clair);
      border-radius: 8px;
      color: var(--texte-doux);
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-deconnexion:hover { background: #FEE2E2; border-color: #FCA5A5; color: #DC2626; }
    .btn-deconnexion svg { width: 16px; height: 16px; }

    /* Sous-menu */
    .nav-item.has-submenu { cursor: pointer; justify-content: flex-start; }
    .nav-item.has-submenu .submenu-arrow { width: 14px; height: 14px; margin-left: auto; transition: transform 0.2s; }
    .nav-item.has-submenu.open .submenu-arrow { transform: rotate(180deg); }
    .submenu { display: none; padding-left: 1rem; background: rgba(0,0,0,0.02); }
    .submenu.open { display: block; }
    .submenu-item { padding-left: 2.5rem; font-size: 0.8rem; }

    /* Header mobile */
    .mobile-header {
      display:none; position:fixed; top:0; left:0; right:0; height:60px;
      background:var(--brun); color:var(--blanc); z-index:100;
      align-items:center; justify-content:space-between; padding:0 1rem;
    }
    .menu-btn {
      background:none; border:none; color:var(--blanc); cursor:pointer; padding:0.5rem;
    }
    .menu-btn svg { width:24px; height:24px; }

    /* Back link */
    .back-link {
      display:inline-flex; align-items:center; gap:0.5rem;
      color:var(--or); text-decoration:none; font-weight:500;
      margin-bottom:1.5rem; transition:color 0.2s;
    }
    .back-link:hover { color:var(--or-clair); }

    /* Article */
    .article {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.04);
    }

    .article-image {
      width:100%; height:400px; object-fit:cover;
    }
    .article-image-placeholder {
      width:100%; height:300px; display:flex; align-items:center; justify-content:center;
      background:linear-gradient(135deg, var(--vert-clair) 0%, var(--vert) 100%);
      color:var(--blanc); font-size:6rem;
    }

    .article-body { padding:2rem; }

    .article-category {
      display:inline-block; padding:0.35rem 1rem; border-radius:20px;
      font-size:0.8rem; font-weight:600; color:var(--blanc); margin-bottom:1rem;
    }

    .article-title {
      font-family:'Cormorant Garamond',serif; font-size:2.5rem;
      color:var(--brun); margin-bottom:1rem; line-height:1.3;
    }

    .article-meta {
      display:flex; justify-content:space-between; align-items:center;
      padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair);
      margin-bottom:1.5rem; color:var(--texte-doux); font-size:0.9rem;
    }

    .article-author { display:flex; align-items:center; gap:0.5rem; }
    .article-stats { display:flex; gap:1.5rem; }
    .stat-item { display:flex; align-items:center; gap:0.35rem; }

    .article-content {
      color:var(--texte); line-height:1.8; font-size:1.05rem;
    }
    .article-content p { margin-bottom:1.25rem; }

    /* Comments section */
    .comments-section {
      margin-top:2.5rem; padding-top:2rem; border-top:1px solid var(--gris-clair);
    }
    .comments-title {
      font-family:'Cormorant Garamond',serif; font-size:1.5rem;
      color:var(--brun); margin-bottom:1.5rem;
    }
    .comment {
      padding:1.25rem; background:var(--creme); border-radius:12px; margin-bottom:1rem;
    }
    .comment-header {
      display:flex; justify-content:space-between; margin-bottom:0.75rem;
    }
    .comment-author { font-weight:600; color:var(--brun); }
    .comment-date { font-size:0.8rem; color:var(--texte-doux); }
    .comment-content { color:var(--texte-doux); line-height:1.6; }
    .no-comments { text-align:center; padding:2rem; color:var(--texte-doux); }

    /* Overlay */
    .sidebar-overlay {
      display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);
      z-index:150; opacity:0; transition:opacity 0.3s;
    }
    .sidebar-overlay.visible { opacity:1; }

    /* Responsive */
    @media (max-width:900px) {
      .mobile-header { display:flex; }
      .page-wrap { margin-left:0; padding:1.5rem; padding-top:80px; }
      .article-image, .article-image-placeholder { height:250px; }
      .article-title { font-size:1.75rem; }
      .article-meta { flex-direction:column; align-items:flex-start; gap:0.75rem; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
    }
  </style>
</head>
<body>
  <!-- Header mobile -->
  <header class="mobile-header">
    <button class="menu-btn" onclick="ouvrirSidebar()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>
    <span>Mboma</span>
    <div style="width:40px"></div>
  </header>

  <div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>

  @include('partials.sidebar')

  <div class="page-wrap">
    <a href="{{ route('informations.index') }}" class="back-link">
      ← Retour aux informations
    </a>

    <article class="article">
      @if($information->image_url)
        <img src="{{ $information->image_url }}" alt="{{ $information->titre }}" class="article-image">
      @else
        <div class="article-image-placeholder">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:64px;height:64px;">
            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
          </svg>
        </div>
      @endif

      <div class="article-body">
        <?php $categorieCouleur = $information->categorieCouleur(); ?>
        <span class="article-category" style="background-color: <?php echo $categorieCouleur; ?>">
          {{ $information->categorieLabel() }}
        </span>

        <h1 class="article-title">{{ $information->titre }}</h1>

        <div class="article-meta">
          <div class="article-author">
            <span>Par {{ $information->auteur->prenom ?? 'Anonyme' }}</span>
            <span>•</span>
            <span>{{ $information->created_at->format('d/m/Y') }}</span>
          </div>
          <div class="article-stats">
            <span class="stat-item">👁 {{ $information->vues }} vues</span>
            <span class="stat-item">💬 {{ $information->commentaires->count() }} commentaires</span>
          </div>
        </div>

        <div class="article-content">
          {!! nl2br(e($information->contenu)) !!}
        </div>
      </div>
    </article>

    <!-- Comments section -->
    <section class="comments-section">
      <h2 class="comments-title">Commentaires ({{ $information->commentairesApprouves->count() }})</h2>

      @forelse($information->commentairesApprouves as $commentaire)
        <div class="comment">
          <div class="comment-header">
            <span class="comment-author">{{ $commentaire->auteur->prenom ?? 'Anonyme' }}</span>
            <span class="comment-date">{{ $commentaire->created_at->format('d/m/Y à H:i') }}</span>
          </div>
          <p class="comment-content">{{ $commentaire->contenu }}</p>
        </div>
      @empty
        <div class="no-comments">
          <p>Aucun commentaire pour le moment. Soyez le premier à réagir !</p>
        </div>
      @endforelse
    </section>
  </div>

  <script>
    function ouvrirSidebar() {
      document.getElementById('sidebar').classList.add('open');
      document.getElementById('overlay').classList.add('visible');
    }
    function fermerSidebar() {
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('visible');
    }
  </script>
</body>
</html>
