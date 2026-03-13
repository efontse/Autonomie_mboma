<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $formation->titre }} — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0;
      --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68;
      --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --erreur:#C0392B; --sidebar-w:280px;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }

    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }

    .retour {
      display:inline-flex; align-items:center; gap:0.5rem;
      color:var(--texte-doux); text-decoration:none; font-size:0.82rem;
      font-weight:500; margin-bottom:1.5rem; transition:color 0.2s;
    }
    .retour:hover { color:var(--or); }
    .retour svg { width:16px; height:16px; }

    .formation-header {
      display:grid; grid-template-columns:1fr 400px; gap:2rem;
      margin-bottom:2rem; align-items:start;
    }

    .header-content h1 {
      font-family:'Cormorant Garamond',serif; font-size:2.2rem;
      font-weight:700; margin-bottom:0.8rem; line-height:1.2;
    }
    .meta-badges { display:flex; gap:0.6rem; flex-wrap:wrap; margin-bottom:1rem; }
    .badge {
      display:inline-flex; align-items:center; gap:0.4rem;
      padding:0.35rem 0.75rem; border-radius:20px;
      font-size:0.75rem; font-weight:500;
    }
    .badge-categorie { background:rgba(201,146,58,0.12); color:var(--or); }
    .badge-niveau { background:rgba(42,96,73,0.1); color:var(--vert); }
    .badge-duree { background:var(--gris-clair); color:var(--texte-doux); }

    .badge svg { width:14px; height:14px; }

    .header-description {
      font-size:0.95rem; line-height:1.7; color:var(--texte-doux);
    }

    .header-actions {
      display:flex; flex-direction:column; gap:0.8rem;
    }

    .action-card {
      background:var(--blanc); border-radius:16px;
      border:1px solid var(--gris-clair); padding:1.5rem;
      text-align:center;
    }
    .action-card .auteur-info {
      display:flex; align-items:center; gap:0.8rem; margin-bottom:1rem;
    }
    .action-card .avatar {
      width:44px; height:44px; border-radius:50%;
      background:var(--or); color:var(--blanc);
      display:flex; align-items:center; justify-content:center;
      font-weight:600; font-size:1rem;
    }
    .action-card .auteur-nom { font-weight:600; font-size:0.9rem; }
    .action-card .auteur-role { font-size:0.75rem; color:var(--texte-doux); }

    .btn {
      display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
      padding:0.8rem 1.5rem; border-radius:10px; font-family:'Outfit',sans-serif;
      font-size:0.9rem; font-weight:500; cursor:pointer; transition:all 0.2s;
      border:none; width:100%;
    }
    .btn-primary {
      background:var(--or); color:var(--brun);
    }
    .btn-primary:hover { background:var(--or-clair); transform:translateY(-1px); }
    .btn-secondary {
      background:transparent; color:var(--texte-doux); border:1.5px solid var(--gris-clair);
    }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }

    .btn svg { width:18px; height:18px; }

    .image-cover {
      width:100%; height:220px; object-fit:cover; border-radius:12px;
      margin-bottom:2rem;
    }

    .content-grid {
      display:grid; grid-template-columns:1fr 320px; gap:2rem;
    }

    .main-content {
      background:var(--blanc); border-radius:16px;
      border:1px solid var(--gris-clair); padding:2rem;
    }

    .section-titre {
      font-family:'Cormorant Garamond',serif;
      font-size:1.3rem; font-weight:600; margin-bottom:1rem;
      padding-bottom:0.8rem; border-bottom:1px solid var(--gris-clair);
    }

    .contenu-formation {
      font-size:0.95rem; line-height:1.8; color:var(--texte-doux);
    }
    .contenu-formation p { margin-bottom:1rem; }
    .contenu-formation h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.1rem;
      font-weight:600; color:var(--texte); margin:1.5rem 0 0.5rem;
    }

    .video-container {
      margin:1.5rem 0; border-radius:12px; overflow:hidden;
      aspect-ratio:16/9; background:var(--creme);
    }
    .video-container iframe { width:100%; height:100%; border:none; }

    .documents-list { margin-top:1.5rem; }
    .document-item {
      display:flex; align-items:center; gap:0.8rem; padding:0.8rem 1rem;
      background:var(--creme); border-radius:10px; margin-bottom:0.6rem;
      text-decoration:none; color:var(--texte); transition:all 0.2s;
    }
    .document-item:hover { background:var(--gris-clair); }
    .document-item svg { width:20px; height:20px; color:var(--or); flex-shrink:0; }
    .document-item span { font-size:0.88rem; }

    .sidebar-info {
      display:flex; flex-direction:column; gap:1rem;
    }

    .info-card {
      background:var(--blanc); border-radius:16px;
      border:1px solid var(--gris-clair); padding:1.5rem;
    }
    .info-card h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.1rem;
      font-weight:600; margin-bottom:1rem;
    }

    .info-row {
      display:flex; justify-content:space-between; align-items:center;
      padding:0.6rem 0; border-bottom:1px solid var(--gris-clair);
    }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:0.82rem; color:var(--texte-doux); }
    .info-value { font-size:0.85rem; font-weight:500; }

    .inscrits-list {
      margin-top:1rem; max-height:200px; overflow-y:auto;
    }
    .inscrit-item {
      display:flex; align-items:center; gap:0.6rem; padding:0.5rem 0;
    }
    .inscrit-avatar {
      width:32px; height:32px; border-radius:50%;
      background:var(--vert-clair); color:var(--blanc);
      display:flex; align-items:center; justify-content:center;
      font-size:0.75rem; font-weight:600;
    }
    .inscrit-nom { font-size:0.85rem; }

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

    @media (max-width:1100px) {
      .formation-header { grid-template-columns:1fr; }
      .header-actions { flex-direction:row; }
      .action-card { flex:1; }
      .content-grid { grid-template-columns:1fr; }
    }

    @media (max-width:768px) {
      .page-wrap { margin-left:0; padding:1rem; }
      .header-actions { flex-direction:column; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.ouvert { transform: translateX(0); }
      .btn-menu-mobile { display: flex; }
      .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99; }
      .sidebar-overlay.visible { display: block; }
    }

    /* Bouton menu mobile */
    .btn-menu-mobile {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.5rem;
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 101;
      background: var(--blanc);
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-menu-mobile svg { width: 24px; height: 24px; color: var(--texte); }
  </style>
</head>
<body>
  <button class="btn-menu-mobile" onclick="ouvrirSidebar()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <line x1="3" y1="12" x2="21" y2="12"/>
      <line x1="3" y1="6" x2="21" y2="6"/>
      <line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
  </button>

  <div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>

  @include('partials.sidebar')

  <div class="page-wrap">
    <a href="{{ route('formation.index') }}" class="retour">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
      </svg>
      Retour aux formations
    </a>

    <div class="formation-header">
      <div class="header-content">
        <h1>{{ $formation->titre }}</h1>
        <div class="meta-badges">
          @if($formation->categorie)
          <span class="badge badge-categorie">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            {{ $formation->categorie->nom }}
          </span>
          @endif
          <span class="badge badge-niveau">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            {{ ucfirst($formation->niveau) }}
          </span>
          <span class="badge badge-duree">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            {{ $formation->duree_minutes }} min
          </span>
        </div>
        <p class="header-description">{{ $formation->description }}</p>
      </div>

      <div class="header-actions">
        <div class="action-card">
          <div class="auteur-info">
            <div class="avatar">
              {{ strtoupper(substr($formation->auteur->prenom ?? 'A', 0, 1)) }}
            </div>
            <div>
              <div class="auteur-nom">{{ $formation->auteur->prenom ?? 'Inconnu' }} {{ $formation->auteur->nom ?? '' }}</div>
              <div class="auteur-role">Formateur</div>
            </div>
          </div>

          @auth
            @php
              $inscription = Auth::user()->inscriptionsFormations()
                ->where('formation_id', $formation->id)
                ->first();
            @endphp

            @if($inscription)
              <button class="btn btn-secondary" disabled>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Déjà inscrit
              </button>
              @if($formation->quiz)
                <a href="{{ route('formation.quiz', $formation) }}" class="btn btn-primary">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                  @if(isset($quizResultat) && $quizResultat['aReussi'])
                    Quiz réussi ({{ $quizResultat['meilleureTentative']->score }}%)
                  @else
                    Passer le quiz
                  @endif
                </a>
              @endif
            @else
              <form method="POST" action="{{ route('formation.inscrire', $formation->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                  S'inscrire à la formation
                </button>
              </form>
            @endif
          @else
            <a href="{{ route('auth.login') }}" class="btn btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
              Connectez-vous pour vous inscrire
            </a>
          @endauth
        </div>
      </div>
    </div>

    @if($formation->image_url)
    <img src="{{ asset($formation->image_url) }}" alt="{{ $formation->titre }}" class="image-cover"/>
    @endif

    <div class="content-grid">
      <div class="main-content">
        <h2 class="section-titre">Contenu de la formation</h2>

        <div class="contenu-formation">
          {!! $formation->contenu !!}
        </div>

        @if($formation->video_url)
        <div class="video-container">
          @if(str_contains($formation->video_url, 'youtube.com') || str_contains($formation->video_url, 'youtu.be'))
            @php
              $videoId = '';
              if(preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $formation->video_url, $matches)) {
                $videoId = $matches[1];
              }
            @endphp
            @if($videoId)
              <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
            @endif
          @else
            <iframe src="{{ $formation->video_url }}" allowfullscreen></iframe>
          @endif
        </div>
        @endif

        @if($formation->document_url)
        <div class="documents-list">
          <h3>Documents joints</h3>
          <a href="{{ $formation->document_url }}" target="_blank" class="document-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span>Télécharger le document</span>
          </a>
        </div>
        @endif
      </div>

      <div class="sidebar-info">
        <div class="info-card">
          <h3>Détails</h3>
          <div class="info-row">
            <span class="info-label">Type</span>
            <span class="info-value">{{ ucfirst($formation->type) }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Durée</span>
            <span class="info-value">{{ $formation->duree_minutes }} minutes</span>
          </div>
          <div class="info-row">
            <span class="info-label">Niveau</span>
            <span class="info-value">{{ ucfirst($formation->niveau) }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Vues</span>
            <span class="info-value">{{ $formation->vues ?? 0 }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Inscrits</span>
            <span class="info-value">{{ $formation->inscriptions->count() }}</span>
          </div>
        </div>

        @if($formation->inscriptions->count() > 0)
        <div class="info-card">
          <h3>Participants ({{ $formation->inscriptions->count() }})</h3>
          <div class="inscrits-list">
            @foreach($formation->inscriptions as $inscription)
              @if($inscription->user)
              <div class="inscrit-item">
                <div class="inscrit-avatar">
                  {{ strtoupper(substr($inscription->user->prenom, 0, 1)) }}
                </div>
                <span class="inscrit-nom">{{ $inscription->user->prenom }} {{ $inscription->user->nom }}</span>
              </div>
              @endif
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    function fermerSidebar() {
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('active');
    }
    function toggleSubmenu(element) {
      element.classList.toggle('open');
      const submenu = element.nextElementSibling;
      submenu.classList.toggle('open');
    }
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
