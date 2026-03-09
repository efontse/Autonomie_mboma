<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Formations — Plateforme Mboma</title>
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

    .page-header {
      display:flex; align-items:flex-end; justify-content:space-between;
      margin-bottom:2rem; padding-bottom:1.5rem;
      border-bottom:1px solid var(--gris-clair);
    }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .page-header p  { font-size:0.85rem; color:var(--texte-doux); margin-top:0.3rem; }

    /* Filtres */
    .filtres { display:flex; gap:0.8rem; margin-bottom:2rem; flex-wrap:wrap; }
    .filtre {
      padding:0.5rem 1rem; border-radius:8px; font-size:0.82rem; font-weight:500;
      border:1px solid var(--gris-clair); background:var(--blanc); color:var(--texte-doux);
      cursor:pointer; transition:all 0.2s;
    }
    .filtre:hover, .filtre.actif {
      border-color:var(--or); color:var(--or); background:rgba(201,146,58,0.08);
    }

    /* Grille formations */
    .formations-grid {
      display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1.5rem;
    }

    .formation-card {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      overflow:hidden; transition:all 0.3s; display:flex; flex-direction:column;
    }
    .formation-card:hover {
      transform:translateY(-4px); box-shadow:0 12px 32px rgba(28,16,8,0.1);
      border-color:var(--or-clair);
    }

    .card-image {
      height:160px; background:var(--creme); position:relative; overflow:hidden;
    }
    .card-image img {
      width:100%; height:100%; object-fit:cover;
    }
    .card-badge {
      position:absolute; top:0.8rem; left:0.8rem;
      padding:0.3rem 0.7rem; border-radius:6px;
      font-size:0.7rem; font-weight:600; text-transform:uppercase;
    }
    .badge-video { background:var(--vert); color:var(--blanc); }
    .badge-document { background:var(--or); color:var(--blanc); }
    .badge-cours { background:var(--brun); color:var(--blanc); }

    .card-content { padding:1.2rem; flex:1; display:flex; flex-direction:column; }
    .card-categorie {
      font-size:0.72rem; font-weight:600; color:var(--or); text-transform:uppercase;
      margin-bottom:0.4rem;
    }
    .card-titre {
      font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:700;
      margin-bottom:0.6rem; line-height:1.3;
    }
    .card-titre a { color:var(--texte); text-decoration:none; }
    .card-titre a:hover { color:var(--or); }
    .card-description {
      font-size:0.84rem; color:var(--texte-doux); line-height:1.6;
      flex:1; margin-bottom:1rem;
    }

    .card-meta {
      display:flex; align-items:center; gap:1rem;
      padding-top:0.8rem; border-top:1px solid var(--gris-clair);
      font-size:0.76rem; color:var(--texte-doux);
    }
    .meta-item { display:flex; align-items:center; gap:0.35rem; }
    .meta-item svg { width:14px; height:14px; }

    .card-actions {
      padding:0 1.2rem 1.2rem;
      display:flex; gap:0.6rem;
    }
    .btn {
      flex:1; padding:0.6rem 1rem; border-radius:8px; font-size:0.82rem; font-weight:500;
      text-align:center; text-decoration:none; transition:all 0.2s; cursor:pointer;
    }
    .btn-primary {
      background:var(--or); color:var(--blanc); border:none;
    }
    .btn-primary:hover { background:var(--brun); }
    .btn-secondary {
      background:transparent; color:var(--texte-doux); border:1px solid var(--gris-clair);
    }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }

    /* Vide */
    .vide { text-align:center; padding:4rem 2rem; }
    .vide-icone { width:64px; height:64px; margin:0 auto 1rem; color:var(--gris); }
    .vide h3 { font-family:'Cormorant Garamond',serif; font-size:1.4rem; margin-bottom:0.5rem; }
    .vide p { color:var(--texte-doux); font-size:0.9rem; }

    @media (max-width:900px) {
      .page-wrap { margin-left:0; padding:1.5rem; }
      .formations-grid { grid-template-columns:1fr; }
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
    <div class="page-header">
      <div>
        <h1>Formations</h1>
        <p>Découvrez nos formations pour développer vos compétences</p>
      </div>
    </div>

    <div class="filtres">
      <button class="filtre actif">Toutes</button>
      <button class="filtre">Vidéo</button>
      <button class="filtre">Document</button>
      <button class="filtre">Cours</button>
      <button class="filtre">Débutant</button>
      <button class="filtre">Intermédiaire</button>
      <button class="filtre">Avancé</button>
    </div>

    @if($formations->isEmpty())
      <div class="vide">
        <svg class="vide-icone" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <h3>Aucune formation disponible</h3>
        <p>Revenez bientôt pour découvrir nos formations.</p>
      </div>
    @else
      <div class="formations-grid">
        @foreach($formations as $formation)
          <article class="formation-card">
            <div class="card-image">
              @if($formation->image_url)
                <img src="{{ $formation->image_url }}" alt="{{ $formation->titre }}"/>
              @endif
              <span class="card-badge badge-{{ $formation->type }}">
                {{ $formation->type }}
              </span>
            </div>
            <div class="card-content">
              @if($formation->categorie)
                <div class="card-categorie">{{ $formation->categorie->nom }}</div>
              @endif
              <h2 class="card-titre">
                <a href="{{ route('formation.show', $formation) }}">{{ $formation->titre }}</a>
              </h2>
              <p class="card-description">{{ Str::limit($formation->description, 120) }}</p>
              <div class="card-meta">
                @if($formation->duree_minutes)
                  <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $formation->duree_minutes }} min
                  </span>
                @endif
                @if($formation->niveau)
                  <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    {{ $formation->niveau }}
                  </span>
                @endif
                <span class="meta-item">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  {{ $formation->vues ?? 0 }} vues
                </span>
              </div>
            </div>
            <div class="card-actions">
              <a href="{{ route('formation.show', $formation) }}" class="btn btn-primary">Voir</a>
              @auth
                <form action="{{ route('formation.inscrire', $formation) }}" method="POST" class="form-inscription">
                  @csrf
                  <button type="submit" class="btn btn-secondary btn-inscription">S'inscrire</button>
                </form>
              @else
                <a href="{{ route('auth.connexion') }}" class="btn btn-secondary">Se connecter pour s'inscrire</a>
              @endauth
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>

  <script>
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

    // Gestion de la soumission du formulaire d'inscription
    document.querySelectorAll('.form-inscription').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.btn-inscription');
        btn.textContent = 'Inscription...';
        btn.disabled = true;

        fetch(this.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message || 'Inscription réussie !');
            btn.textContent = 'Inscrit';
            btn.classList.add('btn-success');
          } else {
            alert(data.message || 'Une erreur est survenue');
            btn.textContent = 'S\'inscrire';
            btn.disabled = false;
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          // Recharger la page pour voir le résultat
          window.location.reload();
        });
      });
    });
  </script>
</body>
</html>
