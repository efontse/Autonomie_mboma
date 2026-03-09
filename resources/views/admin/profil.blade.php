<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mon Profil — Admin Mboma</title>
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
    @media (max-width: 900px) {
      .menu-toggle { display: block; }
    }

    .form-card {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      padding:2rem; max-width:600px;
    }
    @media (max-width: 768px) {
      .page-wrap { margin-left: 0; padding: 1rem; }
      .form-card { padding: 1rem; }
      .page-header h1 { font-size: 1.5rem; }
    }
    .form-group { margin-bottom:1.5rem; }
    .form-group label {
      display:block; font-size:0.85rem; font-weight:500; margin-bottom:0.5rem; color:var(--texte);
    }
    .form-group input {
      width:100%; padding:0.75rem; border:1px solid var(--gris-clair);
      border-radius:8px; font-size:0.9rem; font-family:inherit;
    }
    .form-group input:focus { outline:none; border-color:var(--or); }
    .form-group .help { font-size:0.75rem; color:var(--gris); margin-top:0.25rem; }

    .btn {
      display:inline-flex; align-items:center; gap:0.5rem; padding:0.75rem 1.5rem;
      border-radius:8px; font-size:0.9rem; font-weight:500; text-decoration:none;
      transition:all 0.2s; border:none; cursor:pointer;
    }
    .btn-primary { background:var(--or); color:var(--blanc); }
    .btn-primary:hover { background:var(--brun); }

    .alert {
      padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-size:0.9rem;
    }
    .alert-success { background:#D1FAE5; color:#059669; border:1px solid #A7F3D0; }
    .alert-error { background:#FEE2E2; color:#DC2626; border:1px solid #FECACA; }

    .info-card {
      background:var(--creme); border-radius:8px; padding:1.5rem; margin-bottom:1.5rem;
    }
    .info-card h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.2rem; margin-bottom:1rem;
    }
    .info-row {
      display:flex; justify-content:space-between; padding:0.5rem 0;
      border-bottom:1px solid var(--gris-clair);
    }
    .info-row:last-child { border-bottom:none; }
    .info-label { color:var(--texte-doux); }
    .info-value { font-weight:500; }

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

    .sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--gris-clair); }
    .btn-deconnexion {
      width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
      padding: 0.6rem 0.75rem; background: transparent; border: 1px solid var(--gris-clair);
      border-radius: 6px; color: var(--texte-doux); font-size: 0.75rem; font-weight: 500;
      cursor: pointer; transition: all 0.2s; text-decoration: none;
    }
    .btn-deconnexion:hover { background: #FEE2E2; border-color: #FCA5A5; color: #DC2626; }
    .btn-deconnexion svg { width: 14px; height: 14px; }

    @media (max-width: 900px) {
      .page-wrap { margin-left: 0; padding: 1rem; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.ouvert { transform: translateX(0); }
      .form-card { padding: 1rem; }
      .page-header h1 { font-size: 1.5rem; }
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
  @include('partials.sidebar-admin')

  <div class="page-wrap">
    <div class="page-header">
      <button class="menu-toggle" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
      <h1>Mon Profil</h1>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="form-card">
      <div class="info-card">
        <h3>Informations du compte</h3>
        <div class="info-row">
          <span class="info-label">Rôle</span>
          <span class="info-value">{{ ucfirst($user->role) }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Membre depuis</span>
          <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
        </div>
      </div>

      <form method="POST" action="{{ route('admin.profil.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
        </div>

        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
      </form>
    </div>
  </div>
</body>
</html>
