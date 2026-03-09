<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
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
    .stat-icone.violet { background:#EDE9FE; color:#7C3AED; }
    .stat-info h3 { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:700; }
    .stat-info p { font-size:0.85rem; color:var(--texte-doux); }

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

    /* Table */
    .table-wrap {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      overflow:hidden; margin-top:2rem;
    }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:1rem; text-align:left; border-bottom:1px solid var(--gris-clair); }
    th { background:var(--creme); font-weight:600; font-size:0.85rem; }
    td { font-size:0.9rem; }
    tr:last-child td { border-bottom:none; }
    tr:hover { background:var(--creme); }

    .badge {
      display:inline-block; padding:0.25rem 0.5rem; border-radius:4px;
      font-size:0.75rem; font-weight:600;
    }
    .badge-admin { background:#FEE2E2; color:#DC2626; }
    .badge-mod { background:#DBEAFE; color:#2563EB; }
    .badge-user { background:#D1FAE5; color:#059669; }

    .actions { display:flex; gap:0.5rem; }
    .btn-action {
      padding:0.4rem 0.8rem; border-radius:6px; font-size:0.8rem;
      text-decoration:none; border:1px solid var(--gris-clair);
      background:var(--blanc); color:var(--texte-doux); cursor:pointer;
    }
    .btn-action:hover { border-color:var(--or); color:var(--or); }
    .btn-danger:hover { border-color:var(--rouge); color:var(--rouge); }

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
    .avatar-status {
      position: absolute; bottom: 0; right: 0;
      width: 12px; height: 12px;
      background: var(--vert-clair);
      border-radius: 50%;
      border: 2px solid var(--blanc);
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
      text-decoration: none;
    }
    .btn-deconnexion:hover { background: #FEE2E2; border-color: #FCA5A5; color: #DC2626; }
    .btn-deconnexion svg { width: 16px; height: 16px; }

    @media (max-width:900px) {
      .page-wrap { margin-left:0; padding:1.5rem; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.ouvert { transform: translateX(0); }
    }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Administration</h1>
        <p>Gérez la plateforme Mboma</p>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icone bleu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-info">
          <h3>{{ $stats['utilisateurs'] }}</h3>
          <p>Utilisateurs</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icone vert">
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
        <div class="stat-icone or">
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
        <div class="stat-icone violet">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
          </svg>
        </div>
        <div class="stat-info">
          <h3>{{ $stats['publications'] }}</h3>
          <p>Publications</p>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="nav-grid">
      <a href="{{ route('admin.utilisateurs.index') }}" class="nav-card">
        <h3>👥 Utilisateurs</h3>
        <p>Gérer les comptes utilisateurs et les rôles</p>
      </a>

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

    <!-- Derniers utilisateurs -->
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Utilisateur</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($derniersUtilisateurs as $user)
          <tr>
            <td>
              <strong>{{ $user->prenom }} {{ $user->nom }}</strong><br>
              <small style="color:var(--gris)">{{ $user->email }}</small>
            </td>
            <td>
              <span class="badge badge-{{ $user->role === 'admin' ? 'admin' : ($user->role === 'moderateur' ? 'mod' : 'user') }}">
                {{ ucfirst($user->role) }}
              </span>
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td class="actions">
              <a href="{{ route('admin.utilisateurs.show', $user) }}" class="btn-action">Voir</a>
              <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="btn-action">Éditer</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
