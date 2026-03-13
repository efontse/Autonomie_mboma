<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Publier une annonce — Plateforme Mboma</title>
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

    .type-options {
      display:flex; gap:1rem;
    }
    .type-option {
      flex:1;
    }
    .type-option input { display:none; }
    .type-option label {
      display:block; padding:1.5rem; border:2px solid var(--gris-clair); border-radius:12px;
      text-align:center; cursor:pointer; transition:all 0.2s;
    }
    .type-option label:hover { border-color:var(--or-clair); }
    .type-option input:checked + label {
      border-color:var(--or); background:rgba(201,146,58,0.1);
    }
    .type-option .icon { width: 40px; height: 40px; margin-bottom: 0.5rem; display: block; }
    .type-option .icon svg { width: 100%; height: 100%; }
    .type-option .title { font-weight:600; display:block; }
    .type-option .desc { font-size:0.8rem; color:var(--texte-doux); margin-top:0.3rem; }

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
    .btn-primary:hover { background:var(--or-clair); }
    .btn-secondary {
      background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair);
    }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }

    .form-actions {
      display:flex; gap:1rem; margin-top:2rem; padding-top:1.5rem;
      border-top:1px solid var(--gris-clair);
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
        <h1>Publier une annonce</h1>
        <p>Promouvez vos produits ou services</p>
      </div>
    </div>

    @if(session('success'))
      <div style="padding:1rem; background:#D4EDDA; color:#155724; border-radius:8px; margin-bottom:1.5rem;">
        {{ session('success') }}
      </div>
    @endif

    <div class="form-card">
      <form action="{{ route('entrepreneuriat.annonce.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label>Type d'annonce *</label>
          <div class="type-options">
            <div class="type-option">
              <input type="radio" id="type_produit" name="type" value="produit" {{ old('type') == 'produit' ? 'checked' : '' }}>
              <label for="type_produit">
                <span class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg></span>
                <span class="title">Produit</span>
                <span class="desc">Vendre un produit physique</span>
              </label>
            </div>
            <div class="type-option">
              <input type="radio" id="type_service" name="type" value="service" {{ old('type') == 'service' ? 'checked' : '' }}>
              <label for="type_service">
                <span class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></span>
                <span class="title">Service</span>
                <span class="desc">Proposer un service</span>
              </label>
            </div>
          </div>
          @error('type')
            <p style="color:red; font-size:0.8rem; margin-top:0.3rem;">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="titre">Titre de l'annonce *</label>
          <input type="text" id="titre" name="titre" required
                 placeholder="Ex: Vente de poulets fermiers"
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
            <label for="prix">Prix (FCFA)</label>
            <input type="number" id="prix" name="prix" min="0" step="100"
                   placeholder="Ex: 25000"
                   value="{{ old('prix') }}">
            <p class="help-text">Laissez vide si gratuit ou négociable</p>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description"
                    placeholder="Décrivez votre produit ou service en détail...">{{ old('description') }}</textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Publier l'annonce</button>
          <a href="{{ route('entrepreneuriat.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>

<script>
  function toggleSubmenu(element) {
    event.preventDefault();
    event.stopPropagation();
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



