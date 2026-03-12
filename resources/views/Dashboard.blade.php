<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tableau de bord — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#3B1F0A; --brun-mid:#5D3A1A; --or:#C8860A; --or-clair:#D4A853; --or-pale:#F0D9B5;
      --vert:#2D6A4F; --vert-clair:#52B788;
      --blanc:#FFFFFF; --creme:#FDF6EC; --ivoire:#FAF6F0;
      --texte:#2C1810; --texte-doux:#6B5B4F;
      --gris:#9CA3AF; --gris-clair:#E5E0D8;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Outfit', sans-serif;
      background: var(--creme);
      min-height: 100vh;
      color: var(--texte);
    }
    .layout { display: flex; min-height: 100vh; }

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
      background: var(--or-pale);
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
      background: linear-gradient(135deg, var(--vert), var(--vert-clair));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 700;
      color: var(--blanc);
      position: relative;
    }
    .avatar-status {
      position: absolute; bottom: 0; right: 0;
      width: 12px; height: 12px;
      background: var(--vert-clair);
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
    .nav-item.has-submenu { cursor: pointer; justify-content: flex-start; }
    .nav-item.has-submenu .submenu-arrow { width: 14px; height: 14px; margin-left: auto; transition: transform 0.2s; }
    .nav-item.has-submenu.open .submenu-arrow { transform: rotate(180deg); }
    .submenu { display: none; padding-left: 1rem; background: rgba(0,0,0,0.02); }
    .submenu.open { display: block; }
    .submenu-item { padding-left: 2.5rem; font-size: 0.8rem; }
    .nav-badge {
      margin-left: auto;
      background: var(--or);
      color: var(--brun);
      font-size: 0.65rem;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 10px;
    }

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

    /* ── Main ── */
    .main {
      flex: 1;
      margin-left: 280px;
      display: flex;
      flex-direction: column;
    }

    /* Topbar */
    .topbar {
      height: 64px;
      background: var(--blanc);
      border-bottom: 1px solid var(--gris-clair);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .topbar-gauche { display: flex; align-items: center; gap: 1rem; }
    .btn-menu-mobile { display: none; background: none; border: none; cursor: pointer; padding: 0.5rem; }

    /* Barre de recherche */
    .search-bar {
      display: flex;
      align-items: center;
      background: var(--blanc);
      border: 1px solid var(--gris-clair);
      border-radius: 8px;
      padding: 0.5rem 1rem;
      width: 280px;
      transition: all 0.2s;
    }
    .search-bar:focus-within {
      border-color: var(--or);
      box-shadow: 0 0 0 3px rgba(200, 134, 10, 0.1);
    }
    .search-bar svg {
      width: 18px;
      height: 18px;
      color: var(--gris);
      flex-shrink: 0;
    }
    .search-bar input {
      border: none;
      outline: none;
      background: transparent;
      flex: 1;
      font-size: 0.85rem;
      color: var(--texte);
      margin-left: 0.5rem;
    }
    .search-bar input::placeholder {
      color: var(--gris);
    }
    .search-container {
      position: relative;
    }
    .search-results {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--blanc);
      border: 1px solid var(--gris-clair);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-height: 400px;
      overflow-y: auto;
      z-index: 1000;
      margin-top: 0.5rem;
    }
    .search-results.active { display: block; }
    .search-result-section {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid var(--gris-clair);
    }
    .search-result-section:last-child { border-bottom: none; }
    .search-result-section-title {
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--gris);
      margin-bottom: 0.5rem;
    }
    .search-result-item {
      display: block;
      padding: 0.5rem;
      border-radius: 6px;
      color: var(--texte);
      text-decoration: none;
      font-size: 0.85rem;
    }
    .search-result-item:hover { background: var(--ivoire); }
    .search-no-results {
      padding: 1.5rem;
      text-align: center;
      color: var(--gris);
      font-size: 0.85rem;
    }

    @media (max-width: 768px) { .search-bar { width: 200px; } }
    @media (max-width: 600px) { .search-bar { display: none; } }

    .breadcrumb { font-size: 0.85rem; color: var(--gris); }
    .breadcrumb strong { color: var(--texte); font-weight: 600; }
    .topbar-droite { display: flex; align-items: center; gap: 1rem; }
    .btn-notif {
      position: relative;
      width: 40px; height: 40px;
      border-radius: 10px;
      background: var(--ivoire);
      display: flex; align-items: center; justify-content: center;
      color: var(--texte-doux);
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-notif:hover { background: var(--gris-clair); }
    .btn-notif svg { width: 20px; height: 20px; }
    .notif-dot {
      position: absolute; top: 8px; right: 8px;
      width: 8px; height: 8px;
      background: var(--or);
      border-radius: 50%;
      border: 2px solid var(--blanc);
    }
    .topbar-avatar {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--vert), var(--vert-clair));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem; font-weight: 700;
      color: var(--blanc);
      cursor: pointer;
      border: 2px solid var(--or-pale);
    }

    /* Contenu */
    .content { padding: 2rem; flex: 1; }

    /* Animation d'entrée */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .anim { animation: fadeUp 0.5s ease both; }
    .anim-1 { animation-delay: 0.05s; }
    .anim-2 { animation-delay: 0.12s; }
    .anim-3 { animation-delay: 0.19s; }
    .anim-4 { animation-delay: 0.26s; }
    .anim-5 { animation-delay: 0.33s; }
    .anim-6 { animation-delay: 0.40s; }

    /* ── Bannière de bienvenue ── */
    .banniere {
      background: linear-gradient(135deg, var(--brun) 0%, var(--brun-mid) 50%, var(--vert) 100%);
      border-radius: 16px;
      padding: 2rem 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
      position: relative;
      overflow: hidden;
    }
    .banniere::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(circle at 80% 50%, rgba(201,146,58,0.15) 0%, transparent 60%),
        repeating-linear-gradient(45deg, rgba(201,146,58,0.03) 0, rgba(201,146,58,0.03) 1px, transparent 0, transparent 30px);
    }
    .banniere-texte { position: relative; z-index: 1; }
    .banniere-bonjour {
      font-size: 0.78rem;
      font-weight: 500;
      color: var(--or-clair);
      text-transform: uppercase;
      letter-spacing: 0.12em;
      margin-bottom: 0.4rem;
    }
    .banniere-nom {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--blanc);
      line-height: 1.1;
      margin-bottom: 0.5rem;
    }
    .banniere-desc {
      font-size: 0.85rem;
      color: rgba(255,255,255,0.6);
      max-width: 400px;
    }
    .banniere-deco {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 0.5rem;
    }
    .derniere-co {
      font-size: 0.75rem;
      color: rgba(255,255,255,0.45);
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }
    .derniere-co svg { width: 13px; height: 13px; }
    .profil-complete-wrap {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(201,146,58,0.25);
      border-radius: 10px;
      padding: 0.8rem 1.2rem;
      text-align: right;
      min-width: 160px;
    }
    .profil-pct-label {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.5);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 0.5rem;
    }
    .profil-pct-nb {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--or-clair);
      line-height: 1;
    }
    .profil-pct-bar {
      margin-top: 0.5rem;
      height: 4px;
      background: rgba(255,255,255,0.1);
      border-radius: 4px;
      overflow: hidden;
    }
    .profil-pct-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--or), var(--or-clair));
      border-radius: 4px;
      transition: width 1s ease;
    }

    /* ── Cartes statistiques ── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.2rem;
      margin-bottom: 2rem;
    }
    .stat-card {
      background: var(--blanc);
      border-radius: 14px;
      padding: 1.4rem 1.5rem;
      border: 1px solid var(--gris-clair);
      position: relative;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(44,26,14,0.08);
    }
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      border-radius: 14px 14px 0 0;
    }
    .stat-card.or::after   { background: linear-gradient(90deg, var(--or), var(--or-clair)); }
    .stat-card.vert::after { background: linear-gradient(90deg, var(--vert), var(--vert-clair)); }
    .stat-card.bleu::after { background: linear-gradient(90deg, #2980B9, #5DADE2); }
    .stat-card.rose::after { background: linear-gradient(90deg, #8E44AD, #BB8FCE); }

    .stat-icone {
      width: 40px; height: 40px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 1rem;
    }
    .stat-icone.or   { background: rgba(201,146,58,0.12); color: var(--or); }
    .stat-icone.vert { background: rgba(42,96,73,0.1);    color: var(--vert); }
    .stat-icone.bleu { background: rgba(41,128,185,0.1);  color: #2980B9; }
    .stat-icone.rose { background: rgba(142,68,173,0.1);  color: #8E44AD; }
    .stat-icone svg { width: 20px; height: 20px; }

    .stat-nombre {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--texte);
      line-height: 1;
      margin-bottom: 0.3rem;
    }
    .stat-label {
      font-size: 0.78rem;
      color: var(--texte-doux);
      font-weight: 400;
    }
    .stat-sous {
      font-size: 0.7rem;
      color: var(--gris);
      margin-top: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }
    .stat-sous svg { width: 12px; height: 12px; }
    .tendance-hausse { color: #27AE60; }
    .tendance-neutre { color: var(--gris); }

    /* ── Grille principale ── */
    .grille-principale {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    /* Modules / Raccourcis */
    .section-titre {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--texte);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .voir-tout {
      font-family: 'Outfit', sans-serif;
      font-size: 0.75rem;
      color: var(--or);
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.3rem;
      transition: color 0.2s;
    }
    .voir-tout:hover { color: var(--or-clair); }
    .voir-tout svg { width: 14px; height: 14px; }

    .modules-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }
    .module-card {
      background: var(--blanc);
      border: 1px solid var(--gris-clair);
      border-radius: 14px;
      padding: 1.5rem;
      text-decoration: none;
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
      transition: all 0.25s;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }
    .module-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(44,26,14,0.1);
      border-color: transparent;
    }
    .module-card::before {
      content: '';
      position: absolute;
      inset: 0;
      opacity: 0;
      transition: opacity 0.25s;
    }
    .module-card:hover::before { opacity: 1; }

    .module-card.info::before    { background: linear-gradient(135deg, rgba(41,128,185,0.04), rgba(41,128,185,0.02)); }
    .module-card.formation::before { background: linear-gradient(135deg, rgba(201,146,58,0.05), rgba(201,146,58,0.02)); }
    .module-card.entreprise::before { background: linear-gradient(135deg, rgba(42,96,73,0.05), rgba(42,96,73,0.02)); }
    .module-card.communaute::before { background: linear-gradient(135deg, rgba(142,68,173,0.05), rgba(142,68,173,0.02)); }

    .module-icone-wrap {
      width: 46px; height: 46px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
    }
    .module-icone-wrap.info      { background: rgba(41,128,185,0.1); color: #2980B9; }
    .module-icone-wrap.formation  { background: rgba(201,146,58,0.12); color: var(--or); }
    .module-icone-wrap.entreprise { background: rgba(42,96,73,0.1);   color: var(--vert); }
    .module-icone-wrap.communaute { background: rgba(142,68,173,0.1); color: #8E44AD; }
    .module-icone-wrap svg { width: 22px; height: 22px; }

    .module-nom {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--texte);
      margin-bottom: 0.2rem;
    }
    .module-desc {
      font-size: 0.76rem;
      color: var(--texte-doux);
      line-height: 1.4;
    }
    .module-fleche {
      margin-top: auto;
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.72rem;
      font-weight: 600;
    }
    .module-fleche.info      { color: #2980B9; }
    .module-fleche.formation  { color: var(--or); }
    .module-fleche.entreprise { color: var(--vert); }
    .module-fleche.communaute { color: #8E44AD; }
    .module-fleche svg { width: 14px; height: 14px; }

    /* Overlay mobile */
    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 99;
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1100px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .grille-principale { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.ouvert { transform: translateX(0); }
      .sidebar-overlay.visible { display: block; }
      .main { margin-left: 0; }
      .btn-menu-mobile { display: flex; }
      .content { padding: 1.2rem; }
      .banniere { flex-direction: column; align-items: flex-start; gap: 1.2rem; }
      .banniere-deco { align-items: flex-start; width: 100%; }
      .profil-complete-wrap { text-align: left; min-width: unset; width: 100%; }
      .stats-grid { grid-template-columns: 1fr 1fr; }
      .modules-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
      .stats-grid { grid-template-columns: 1fr; }
      .modules-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  @include('partials.sidebar')

  <!-- Contenu principal -->
  <div class="main">
    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-gauche">
        <button class="btn-menu-mobile" onclick="ouvrirSidebar()">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
          </svg>
        </button>
        <div class="search-container">
          <div class="search-bar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="globalSearch" placeholder="Rechercher..." autocomplete="off">
          </div>
          <div class="search-results" id="searchResults"></div>
        </div>
        <div class="breadcrumb" style="display: none;">
          Plateforme Mboma &nbsp;/&nbsp; <strong>Tableau de bord</strong>
        </div>
      </div>
      <div class="topbar-droite">
        <a href="{{ route('notifications.index') }}" class="btn-notif" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
          @if(($notificationsStats['unread'] ?? 0) > 0)
          <span class="notif-dot"></span>
          @endif
        </a>
        <div class="topbar-avatar">
          {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
        </div>
      </div>
    </header>

    <!-- Contenu -->
    <main class="content">
      <!-- Bannière de bienvenue -->
      <div class="banniere anim anim-1">
        <div class="banniere-texte">
          <div class="banniere-bonjour">Bienvenue sur votre espace</div>
          <div class="banniere-nom">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
          <div class="banniere-desc">
            Accédez à vos formations, gérez vos projets et restez connectée à la communauté de Mboma.
          </div>
        </div>
        <div class="banniere-deco">
          <div class="derniere-co">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            Dernière connexion :
            {{ Auth::user()->derniere_connexion ? Auth::user()->derniere_connexion->diffForHumans() : 'Première connexion' }}
          </div>
          <div class="profil-complete-wrap">
            <div class="profil-pct-label">Profil complété</div>
            @php $pct = Auth::user()->profil?->pourcentageCompletude() ?? 0; @endphp
            <div class="profil-pct-nb">{{ $pct }}%</div>
            <div class="profil-pct-bar">
              <div class="profil-pct-fill" style="width: {{$pct}}%;"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cartes statistiques -->
      <div class="stats-grid">
        <div class="stat-card or anim anim-2">
          <div class="stat-icone or">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
          </div>
          <div class="stat-nombre">{{ Auth::user()->formations()->count() }}</div>
          <div class="stat-label">Formations suivies</div>
        </div>

        <div class="stat-card vert anim anim-3">
          <div class="stat-icone vert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <div class="stat-nombre">{{ Auth::user()->publications()->count() }}</div>
          <div class="stat-label">Publications postées</div>
        </div>

        <div class="stat-card bleu anim anim-4">
          <div class="stat-icone bleu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <div class="stat-nombre">{{ Auth::user()->projets()->count() }}</div>
          <div class="stat-label">Projets soumis</div>
        </div>

        <div class="stat-card rose anim anim-5">
          <a href="{{ route('notifications.index') }}" style="text-decoration:none;color:inherit;">
          <div class="stat-icone rose">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
          </div>
          <div class="stat-nombre">{{ $notificationsStats['unread'] ?? 0 }}</div>
          <div class="stat-label">Notifications non lues</div>
          @if(($notificationsStats['total'] ?? 0) > 0)
          <div class="stat-sous">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
              <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ $notificationsStats['total'] ?? 0 }} au total
          </div>
          @endif
          </a>
        </div>
      </div>

      <!-- Modules raccourcis -->
      <div class="anim anim-3" style="margin-bottom: 2rem;">
        <div class="section-titre">
          Mes modules
          <a href="#" class="voir-tout">
            Voir tout
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
        <div class="modules-grid">
          <a href="{{ route('informations.index') }}" class="module-card info">
            <div class="module-icone-wrap info">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>
            </div>
            <div>
              <div class="module-nom">Information</div>
              <div class="module-desc">Actualités locales, santé, droits des femmes</div>
            </div>
            <div class="module-fleche info">
              Accéder
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
          </a>

          <a href="{{ route('formation.index') }}" class="module-card formation">
            <div class="module-icone-wrap formation">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
              </svg>
            </div>
            <div>
              <div class="module-nom">Formation</div>
              <div class="module-desc">Cours, ateliers et certifications</div>
            </div>
            <div class="module-fleche formation">
              Accéder
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
          </a>

          <a href="{{ route('entrepreneuriat.index') }}" class="module-card entreprise">
            <div class="module-icone-wrap entreprise">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
              </svg>
            </div>
            <div>
              <div class="module-nom">Entrepreneuriat</div>
              <div class="module-desc">Projets, financements et accompagnement</div>
            </div>
            <div class="module-fleche entreprise">
              Accéder
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
          </a>

          <a href="{{ route('communaute.index') }}" class="module-card communaute">
            <div class="module-icone-wrap communaute">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <div>
              <div class="module-nom">Communauté</div>
              <div class="module-desc">Échanges, témoignages et entraide</div>
              <div class="module-stats" style="margin-top: 0.5rem; display: flex; gap: 1rem; font-size: 0.7rem; color: var(--texte-doux);">
                <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:3px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> {{ $communityStats['posts'] ?? 0 }} posts</span>
                <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:3px;"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg> {{ $communityStats['myPosts'] ?? 0 }} mes posts</span>
              </div>
            </div>
            <div class="module-fleche communaute">
              Accéder
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
          </a>
        </div>
      </div>

    </main>
  </div>
</div>

<script>
  // Recherche globale
  const searchInput = document.getElementById('globalSearch');
  const searchResults = document.getElementById('searchResults');
  let searchTimeout;

  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      clearTimeout(searchTimeout);
      const query = e.target.value.trim();

      if (query.length < 2) {
        searchResults.classList.remove('active');
        searchResults.innerHTML = '';
        return;
      }

      searchTimeout = setTimeout(() => performSearch(query), 300);
    });

    // Fermer les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.search-container')) {
        searchResults.classList.remove('active');
      }
    });

    // Focus sur la recherche affiche les résultats s'il y a du texte
    searchInput.addEventListener('focus', function() {
      if (searchInput.value.trim().length >= 2) {
        searchResults.classList.add('active');
      }
    });
  }

  function performSearch(query) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('{{ route("search") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ q: query })
    })
    .then(response => response.json())
    .then(data => {
      displayResults(data);
    })
    .catch(error => {
      console.error('Erreur de recherche:', error);
    });
  }

  function displayResults(data) {
    if (!data.formations?.length && !data.informations?.length && !data.projets?.length && !data.publications?.length) {
      searchResults.innerHTML = '<div class="search-no-results">Aucun résultat trouvé</div>';
    } else {
      let html = '';

      if (data.formations?.length) {
        html += '<div class="search-result-section"><div class="search-result-section-title">Formations</div>';
        data.formations.slice(0, 3).forEach(item => {
          html += `<a class="search-result-item" href="{{ url('/formations') }}/${item.id}">📚 ${item.titre}</a>`;
        });
        html += '</div>';
      }

      if (data.informations?.length) {
        html += '<div class="search-result-section"><div class="search-result-section-title">Informations</div>';
        data.informations.slice(0, 3).forEach(item => {
          html += `<a class="search-result-item" href="{{ url('/informations') }}/${item.id}">📰 ${item.titre}</a>`;
        });
        html += '</div>';
      }

      if (data.projets?.length) {
        html += '<div class="search-result-section"><div class="search-result-section-title">Projets</div>';
        data.projets.slice(0, 3).forEach(item => {
          html += `<a class="search-result-item" href="{{ url('/entrepreneuriat/projets') }}/${item.id}">💼 ${item.titre}</a>`;
        });
        html += '</div>';
      }

      if (data.publications?.length) {
        html += '<div class="search-result-section"><div class="search-result-section-title">Publications</div>';
        data.publications.slice(0, 3).forEach(item => {
          html += `<a class="search-result-item" href="{{ route('communaute.index') }}">💬 ${item.contenu.substring(0, 50)}...</a>`;
        });
        html += '</div>';
      }

      searchResults.innerHTML = html;
    }

    searchResults.classList.add('active');
  }

  function ouvrirSidebar() {
    document.getElementById('sidebar').classList.add('ouvert');
    document.getElementById('overlay').classList.add('visible');
  }
  function fermerSidebar() {
    document.getElementById('sidebar').classList.remove('ouvert');
    document.getElementById('overlay').classList.remove('visible');
  }
</script>

</body>
<script>
  function toggleSubmenu(element) {
    element.classList.toggle('open');
    const submenu = element.nextElementSibling;
    submenu.classList.toggle('open');
  }
</script>
</html>

