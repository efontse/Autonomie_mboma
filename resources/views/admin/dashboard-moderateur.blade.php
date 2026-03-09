<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modération — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0;
      --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68;
      --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --rouge:#DC2626; --sidebar-w:280px;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }

    /* Header */
    .page-header {
      display:flex; align-items:flex-end; justify-content:space-between;
      margin-bottom:2rem; padding-bottom:1.5rem;
      border-bottom:1px solid var(--gris-clair);
    }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .menu-toggle {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.5rem;
    }
    .menu-toggle svg { width: 24px; height: 24px; stroke: var(--texte); }

    /* Stats */
    .stats-grid {
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
      gap:1.5rem;
      margin-bottom:2rem;
    }
    .stat-card {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      padding:1.5rem; display:flex; align-items:center; gap:1rem;
    }
    .stat-icone {
      width:48px; height:48px; border-radius:12px;
      display:flex; align-items:center; justify-content:center;
    }
    .stat-icone svg { width:24px; height:24px; }
    .stat-icone.bleu { background:#DBEAFE; color:#2563EB; }
    .stat-icone.vert { background:#D1FAE5; color:#059669; }
    .stat-icone.or { background:#FEF3C7; color:#D97706; }
    .stat-info h3 { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:700; }
    .stat-info p { font-size:0.85rem; color:var(--texte-doux); }

    /* Graphiques */
    .charts-grid {
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(400px,1fr));
      gap:1.5rem;
      margin-bottom:2rem;
    }
    .chart-card {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      padding:1.5rem;
    }
    .chart-card h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:600;
      margin-bottom:1rem; color:var(--texte);
    }
    .chart-container {
      position:relative;
      height:250px;
    }

    /* Navigation cards */
    .nav-grid {
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
      gap:1.5rem;
    }
    .nav-card {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      padding:1.5rem; text-decoration:none; color:inherit;
      transition:all 0.2s;
    }
    .nav-card:hover { border-color:var(--or); transform:translateY(-2px); }
    .nav-card h3 { font-family:'Cormorant Garamond',serif; font-size:1.2rem; margin-bottom:0.5rem; }
    .nav-card p { font-size:0.85rem; color:var(--texte-doux); }

    /* Sidebar styles */
    .sidebar {
      width: 280px;
      background: var(--blanc);
      border-right: 1px solid var(--gris-clair);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
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
    .logo-sub { font-size: 0.7rem; color: var(--gris); text-transform: uppercase; }

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
    .profil-info { flex: 1; }
    .profil-nom { font-weight: 600; font-size: 0.9rem; }
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
    .nav-item:hover, .nav-item.active {
      background: var(--creme);
      border-left-color: var(--or);
      color: var(--or);
    }
    .nav-item svg { width: 18px; height: 18px; }

    .sidebar-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid var(--gris-clair);
    }
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
      text-decoration: none;
    }
    .btn-deconnexion:hover {
      background: #FEE2E2;
      border-color: #FCA5A5;
      color: #DC2626;
    }
    .btn-deconnexion svg { width: 16px; height: 16px; }
    .sidebar-overlay { display: none; }

    @media (max-width: 900px) {
      .page-wrap { margin-left: 0; padding: 1rem; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.ouvert { transform: translateX(0); }
      .charts-grid { grid-template-columns: 1fr; }
      .stats-grid { grid-template-columns: 1fr; }
      .nav-grid { grid-template-columns: 1fr; }
      .page-header h1 { font-size: 1.5rem; }
      .menu-toggle { display: block; }
    }
  </style>
  <script>
    function toggleSidebar() {
      var sidebar = document.getElementById('sidebar');
      var overlay = document.getElementById('overlay');
      if (sidebar) {
        sidebar.classList.toggle('ouvert');
        if (overlay) {
          overlay.style.display = sidebar.classList.contains('ouvert') ? 'block' : 'none';
        }
      }
    }
    function fermerSidebar() {
      var sidebar = document.getElementById('sidebar');
      var overlay = document.getElementById('overlay');
      if (sidebar) sidebar.classList.remove('ouvert');
      if (overlay) overlay.style.display = 'none';
    }
  </script>
</head>
<body>
  <!-- Sidebar -->
  @include('partials.sidebar-moderateur')

  <div class="page-wrap">
    <div class="page-header">
      <button class="menu-toggle" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
      <h1>Dashboard Modération</h1>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icone or">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
          </svg>
        </div>
        <div class="stat-info">
          <h3>{{ $stats['formations'] }}</h3>
          <p>Formations</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icone bleu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
        </div>
        <div class="stat-info">
          <h3>{{ $stats['informations'] }}</h3>
          <p>Informations</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icone vert">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-info">
          <h3>{{ $stats['inscriptions'] }}</h3>
          <p>Inscriptions</p>
        </div>
      </div>
    </div>

    <!-- Graphiques -->
    <div class="charts-grid">
      <div class="chart-card">
        <h3>📚 Formations populaires</h3>
        <div class="chart-container">
          <canvas id="formationsChart"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <h3>📊 Inscriptions par catégorie</h3>
        <div class="chart-container">
          <canvas id="categoriesChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="nav-grid">
      <a href="{{ route('admin.formations.index') }}" class="nav-card">
        <h3>📚 Formations</h3>
        <p>Créer, modifier ou supprimer des formations</p>
      </a>

      <a href="{{ route('admin.informations.index') }}" class="nav-card">
        <h3>📰 Informations</h3>
        <p>Publier des articles et actualités</p>
      </a>

      <a href="{{ route('admin.categories.index') }}" class="nav-card">
        <h3>🏷️ Catégories</h3>
        <p>Gérer les catégories de formations</p>
      </a>
    </div>
  </div>

  @php
  // Préparation des données pour les graphiques
  $formationsLabels = $formationsPopulaires->pluck('titre')->map(function($t) {
      return strlen($t) > 25 ? substr($t, 0, 25) . '...' : $t;
  })->toArray();
  $formationsData = $formationsPopulaires->pluck('inscriptions_count')->toArray();
  $categoriesLabels = $inscriptionsParCategorie->pluck('nom')->toArray();
  $categoriesData = $inscriptionsParCategorie->pluck('inscriptions')->toArray();
  @endphp

  <script>
    // @ts-nocheck
    // eslint-disable
    // Graphique des formations populaires
    const formationsCtx = document.getElementById('formationsChart').getContext('2d');
    /* eslint-disable no-undef */
    new Chart(formationsCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($formationsLabels) !!},
        datasets: [{
          label: "Nombre d'inscriptions",
          data: {!! json_encode($formationsData) !!},
          backgroundColor: '#C9923A',
          borderColor: '#1C1008',
          borderWidth: 1,
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 1 }
          }
        }
      }
    });

    // Graphique des inscriptions par catégorie
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($categoriesLabels) !!},
        datasets: [{
          data: {!! json_encode($categoriesData) !!},
          backgroundColor: [
            '#C9923A', '#2A6049', '#2563EB', '#7C3AED', '#DC2626', '#059669'
          ],
          borderWidth: 2,
          borderColor: '#FFFFFF'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              padding: 15,
              usePointStyle: true
            }
          }
        }
      }
    });
  </script>
</body>
</html>
