<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Soumettre un projet — Plateforme Mboma</title>
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
    .page-header p { font-size:0.85rem; color:var(--texte-doux); margin-top:0.3rem; }

    .back-link {
      display:inline-flex; align-items:center; gap:0.5rem; color:var(--texte-doux);
      text-decoration:none; margin-bottom:1.5rem; font-size:0.9rem;
    }
    .back-link:hover { color:var(--or); }

    .form-card {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      padding:2rem; max-width:700px;
    }

    .form-group { margin-bottom:1.5rem; }
    .form-group label {
      display:block; font-weight:500; margin-bottom:0.5rem; color:var(--texte);
    }
    .form-group input, .form-group select, .form-group textarea {
      width:100%; padding:0.8rem 1rem; border-radius:8px; border:1px solid var(--gris-clair);
      font-family:'Outfit',sans-serif; font-size:0.95rem; transition:border-color 0.2s;
      background:var(--blanc); color:var(--texte);
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      outline:none; border-color:var(--or);
    }
    .form-group textarea { min-height:150px; resize:vertical; }
    .form-group .help-text {
      font-size:0.8rem; color:var(--texte-doux); margin-top:0.3rem;
    }

    .form-row {
      display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;
    }

    .btn {
      padding:0.7rem 1.4rem; border-radius:8px; font-size:0.9rem; font-weight:500;
      text-decoration:none; cursor:pointer; border:none; transition:all 0.2s;
      display:inline-flex; align-items:center; gap:0.5rem;
    }
    .btn-primary {
      background:var(--or); color:var(--blanc);
    }
    .btn-primary:hover {
      background:var(--or-clair);
    }
    .btn-secondary {
      background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair);
    }
    .btn-secondary:hover {
      border-color:var(--or); color:var(--or);
    }

    .form-actions {
      display:flex; gap:1rem; margin-top:2rem; padding-top:1.5rem;
      border-top:1px solid var(--gris-clair);
    }

    .alert {
      padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-size:0.9rem;
    }
    .alert-success {
      background:#D4EDDA; color:#155724; border:1px solid #C3E6CB;
    }
    .alert-error {
      background:#F8D7DA; color:#721C24; border:1px solid #F5C6CB;
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

    /* Sidebar */
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

    /* Overlay */
    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 99;
    }
    .sidebar-overlay.visible { display: block; }

    @media (max-width:900px) {
      .page-wrap { margin-left:0; padding:1.5rem; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .btn-menu-mobile { display: flex; }
      .sidebar-overlay { display: none; }
      .sidebar-overlay.visible { display: block; }
    }
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
    <a href="{{ route('entrepreneuriat.index') }}" class="back-link">
      ← Retour au module entrepreneuriat
    </a>

    <div class="page-header">
      <div>
        <h1>Soumettre un projet entrepreneurial</h1>
        <p>Présentez votre projet et recherchez un financement ou un accompagnement</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="form-card">
      <form action="{{ route('entrepreneuriat.projet.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label for="titre">Titre du projet *</label>
          <input type="text" id="titre" name="titre" required
                 placeholder="Ex: Élevages de poulets fermiers bio"
                 value="{{ old('titre') }}">
          @error('titre')
            <p style="color:red; font-size:0.8rem; margin-top:0.3rem;">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="secteur">Secteur d'activité *</label>
            <select id="secteur" name="secteur" required>
              <option value="">Sélectionner un secteur</option>
              @foreach($secteurs as $key => $label)
                <option value="{{ $key }}" {{ old('secteur') == $key ? 'selected' : '' }}>
                  {{ $label }}
                </option>
              @endforeach
            </select>
            @error('secteur')
              <p style="color:red; font-size:0.8rem; margin-top:0.3rem;">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label for="budget">Budget estimé (FCFA)</label>
            <input type="number" id="budget" name="budget" min="0" step="1000"
                   placeholder="Ex: 500000"
                   value="{{ old('budget') }}">
            <p class="help-text">Budget nécessaire pour démarrer le projet</p>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Description du projet</label>
          <textarea id="description" name="description"
                    placeholder="Décrivez votre projet en détail : objectifs, activities prevues, etc.">{{ old('description') }}</textarea>
          @error('description')
            <p style="color:red; font-size:0.8rem; margin-top:0.3rem;">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Soumettre le projet</button>
          <a href="{{ route('entrepreneuriat.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
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



