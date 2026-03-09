<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mes formations — Plateforme Mboma</title>
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

    /* Résumé stats */
    .resume {
      display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;
    }
    .resume-card {
      background:var(--blanc); border:1px solid var(--gris-clair);
      border-radius:12px; padding:1.2rem 1.5rem;
      display:flex; align-items:center; gap:1rem;
    }
    .resume-icone {
      width:44px; height:44px; border-radius:10px;
      display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .resume-icone svg { width:22px; height:22px; }
    .resume-val {
      font-family:'Cormorant Garamond',serif;
      font-size:1.8rem; font-weight:700; color:var(--texte); line-height:1;
    }
    .resume-label { font-size:0.76rem; color:var(--texte-doux); margin-top:3px; }

    /* Onglets */
    .onglets { display:flex; gap:0.4rem; margin-bottom:1.8rem; }
    .onglet {
      padding:0.5rem 1.2rem; border-radius:8px; font-size:0.84rem; font-weight:500;
      border:1.5px solid var(--gris-clair); background:var(--blanc);
      color:var(--texte-doux); cursor:pointer; transition:all 0.2s; text-decoration:none;
    }
    .onglet.actif, .onglet:hover { background:var(--brun); color:var(--blanc); border-color:var(--brun); }
    .onglet-nb {
      display:inline-block; background:var(--gris-clair); color:var(--gris);
      font-size:0.65rem; font-weight:700; padding:1px 6px;
      border-radius:10px; margin-left:0.3rem;
    }
    .onglet.actif .onglet-nb { background:rgba(255,255,255,0.2); color:var(--blanc); }

    /* Liste formations inscrites */
    .formations-list { display:flex; flex-direction:column; gap:1rem; }
    .formation-row {
      background:var(--blanc); border:1px solid var(--gris-clair);
      border-radius:13px; overflow:hidden;
      display:flex; align-items:stretch;
      transition:all 0.2s; text-decoration:none; color:inherit;
    }
    .formation-row:hover { box-shadow:0 6px 20px rgba(44,26,14,0.08); border-color:rgba(201,146,58,0.3); }

    .row-image {
      width:120px; flex-shrink:0; background:var(--creme);
      display:flex; align-items:center; justify-content:center; overflow:hidden;
    }
    .row-image img { width:100%; height:100%; object-fit:cover; }
    .row-image svg { width:32px; height:32px; opacity:0.15; color:var(--or); }

    .row-body { flex:1; padding:1.1rem 1.3rem; min-width:0; }
    .row-cat { font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:0.3rem; }
    .row-titre {
      font-family:'Cormorant Garamond',serif;
      font-size:1.1rem; font-weight:600; color:var(--texte);
      margin-bottom:0.5rem; line-height:1.3;
    }
    .row-meta { display:flex; align-items:center; gap:1rem; font-size:0.75rem; color:var(--gris); }
    .row-meta-it { display:flex; align-items:center; gap:0.3rem; }
    .row-meta-it svg { width:12px; height:12px; }

    .row-prog { width:180px; flex-shrink:0; padding:1.1rem 1.3rem; display:flex; flex-direction:column; justify-content:center; gap:0.6rem; border-left:1px solid var(--gris-clair); }
    .row-prog-label { display:flex; justify-content:space-between; font-size:0.76rem; }
    .row-prog-label span { color:var(--texte-doux); }
    .row-prog-label strong { color:var(--vert); }
    .row-prog-bar { height:5px; background:var(--gris-clair); border-radius:5px; overflow:hidden; }
    .row-prog-fill { height:100%; background:linear-gradient(90deg,var(--vert),var(--vert-clair)); border-radius:5px; }

    .badge-termine {
      display:inline-flex; align-items:center; gap:0.35rem;
      font-size:0.72rem; font-weight:700; color:var(--or);
      background:rgba(201,146,58,0.1); padding:0.3rem 0.7rem;
      border-radius:20px;
    }
    .badge-termine svg { width:11px; height:11px; }

    .cert-lien {
      display:flex; align-items:center; gap:0.35rem;
      font-size:0.73rem; font-weight:600; color:var(--or);
      text-decoration:none;
    }
    .cert-lien:hover { text-decoration:underline; }
    .cert-lien svg { width:12px; height:12px; }

    /* Vide */
    .vide {
      text-align:center; padding:4rem 2rem;
      background:var(--blanc); border:1px solid var(--gris-clair); border-radius:14px;
      color:var(--gris);
    }
    .vide svg { width:48px; height:48px; margin:0 auto 1rem; display:block; opacity:0.25; }
    .vide p { font-size:0.88rem; margin-bottom:1.2rem; }

    /* Pagination */
    .pagination { display:flex; justify-content:center; gap:0.4rem; margin-top:1.5rem; flex-wrap:wrap; }
    .pg { padding:0.5rem 0.9rem; border-radius:8px; font-size:0.82rem; font-weight:500; border:1.5px solid var(--gris-clair); color:var(--texte-doux); text-decoration:none; transition:all 0.2s; }
    .pg:hover, .pg.actif { background:var(--brun); color:var(--blanc); border-color:var(--brun); }
    .pg.off { opacity:0.4; pointer-events:none; }

    @media (max-width:900px) { .resume { grid-template-columns:1fr 1fr; } .row-prog { display:none; } .sidebar { transform: translateX(-100%); } .sidebar.ouvert { transform: translateX(0); } .btn-menu-mobile { display: flex; } .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99; } .sidebar-overlay.visible { display: block; } }
    @media (max-width:768px) { .page-wrap { margin-left:0; padding:1.2rem; } .resume { grid-template-columns:1fr; } }

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
      <h1>Mes formations</h1>
      <p>Suivez votre progression et accédez à vos certificats.</p>
    </div>
    <a href="{{ route('formation.index') }}"
       style="display:flex;align-items:center;gap:0.5rem;padding:0.65rem 1.2rem;background:var(--brun);color:var(--blanc);border-radius:9px;text-decoration:none;font-size:0.84rem;font-weight:600;transition:all 0.2s"
       onmouseover="this.style.background='var(--or)'" onmouseout="this.style.background='var(--brun)'">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      Découvrir des formations
    </a>
  </div>

  {{-- Résumé --}}
  @php
    $total    = $inscriptions->count();
    $terminees = auth()->user()->formations()->where('termine', true)->count();
    $enCours  = auth()->user()->formations()->where('termine', false)->where('progression', '>', 0)->count();
  @endphp
  <div class="resume">
    <div class="resume-card">
      <div class="resume-icone" style="background:rgba(201,146,58,0.1)">
        <svg viewBox="0 0 24 24" fill="none" stroke="#C9923A" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      </div>
      <div>
        <div class="resume-val">{{ $total }}</div>
        <div class="resume-label">Formation(s) inscrite(s)</div>
      </div>
    </div>
    <div class="resume-card">
      <div class="resume-icone" style="background:rgba(42,96,73,0.1)">
        <svg viewBox="0 0 24 24" fill="none" stroke="#2A6049" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <div class="resume-val">{{ $terminees }}</div>
        <div class="resume-label">Terminée(s)</div>
      </div>
    </div>
    <div class="resume-card">
      <div class="resume-icone" style="background:rgba(243,156,18,0.1)">
        <svg viewBox="0 0 24 24" fill="none" stroke="#F39C12" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="resume-val">{{ $enCours }}</div>
        <div class="resume-label">En cours</div>
      </div>
    </div>
  </div>

  {{-- Onglets filtre --}}
  <div class="onglets">
    <a href="{{ route('formation.mes-formations') }}"
       class="onglet {{ !request('filtre') ? 'actif' : '' }}">
      Toutes <span class="onglet-nb">{{ $total }}</span>
    </a>
    <a href="{{ route('formation.mes-formations', ['filtre' => 'en_cours']) }}"
       class="onglet {{ request('filtre') === 'en_cours' ? 'actif' : '' }}">
      En cours <span class="onglet-nb">{{ $enCours }}</span>
    </a>
    <a href="{{ route('formation.mes-formations', ['filtre' => 'terminees']) }}"
       class="onglet {{ request('filtre') === 'terminees' ? 'actif' : '' }}">
      Terminées <span class="onglet-nb">{{ $terminees }}</span>
    </a>
  </div>

  {{-- Liste --}}
  <div class="formations-list">
    @forelse($inscriptions as $ins)
      @php $f = $ins->formation; @endphp
      <a href="{{ route('formation.show', $f) }}" class="formation-row">

        <div class="row-image">
          @if($f->image_url)
            <img src="{{ asset('storage/'.$f->image_url) }}" alt="{{ $f->titre }}"/>
          @else
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
          @endif
        </div>

        <div class="row-body">
          @php $styleCouleur = 'color:' . $f->categorie->couleur; @endphp
          <div class="row-cat" style="<?php echo $styleCouleur; ?>">{{ $f->categorie->nom }}</div>
          <div class="row-titre">{{ $f->titre }}</div>
          <div class="row-meta">
            <span class="row-meta-it">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Inscrite le {{ $ins->inscrit_le->format('d/m/Y') }}
            </span>
            @if($ins->termine && $ins->termine_le)
              <span class="row-meta-it">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Terminée le {{ $ins->termine_le->format('d/m/Y') }}
              </span>
            @endif
            @if($f->duree_minutes)
              <span class="row-meta-it">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $f->dureeFormatee() }}
              </span>
            @endif
          </div>

          @if($ins->termine && $ins->certificat_url)
            <div style="margin-top:0.6rem">
              <a href="{{ asset('storage/'.$ins->certificat_url) }}" download
                 onclick="event.stopPropagation()" class="cert-lien">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Télécharger mon certificat
              </a>
            </div>
          @endif
        </div>

        <div class="row-prog">
          @if($ins->termine)
            <span class="badge-termine">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Formation terminée
            </span>
          @else
            <div class="row-prog-label">
              <span>Progression</span>
              <strong>{{ $ins->progression }}%</strong>
            </div>
            <div class="row-prog-bar">
              @php $styleLargeur = 'width:' . $ins->progression . '%'; @endphp
              <div class="row-prog-fill" style="<?php echo $styleLargeur; ?>"></div>
            </div>
            <span style="font-size:0.72rem;color:var(--gris)">
              {{ $ins->progression === 0 ? 'Pas encore commencé' : 'En cours' }}
            </span>
          @endif
        </div>

      </a>
    @empty
      <div class="vide">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        <p>Vous n'êtes inscrite à aucune formation pour l'instant.</p>
        <a href="{{ route('formation.index') }}"
           style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;background:var(--brun);color:var(--blanc);border-radius:9px;text-decoration:none;font-size:0.84rem;font-weight:600">
          Découvrir les formations
        </a>
      </div>
    @endforelse
  </div>

  {{-- Pas de pagination pour une Collection --}}

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
</script>
</body>
</html>
