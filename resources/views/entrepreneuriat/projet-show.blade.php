<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $projet->titre }} — Plateforme Mboma</title>
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

    .back-link {
      display:inline-flex; align-items:center; gap:0.5rem; color:var(--texte-doux);
      text-decoration:none; margin-bottom:1.5rem; font-size:0.9rem;
    }
    .back-link:hover { color:var(--or); }

    .projet-card {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      padding:2rem; max-width:800px;
    }

    .projet-header {
      display:flex; justify-content:space-between; align-items:flex-start;
      margin-bottom:1.5rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair);
    }

    .projet-titre {
      font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700;
      color:var(--brun); margin-bottom:0.5rem;
    }

    .projet-statut {
      padding:0.4rem 1rem; border-radius:4px; font-size:0.85rem; font-weight:600;
    }
    .statut-en_attente { background:#FFF3CD; color:#856404; }
    .statut-valide { background:#D4EDDA; color:#155724; }
    .statut-rejete { background:#F8D7DA; color:#721C24; }

    .projet-meta {
      display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.5rem;
      margin-bottom:2rem;
    }

    .meta-item label {
      display:block; font-size:0.8rem; color:var(--texte-doux); margin-bottom:0.3rem;
    }
    .meta-item span {
      font-weight:500;
    }

    .secteur-badge {
      display:inline-block; padding:0.3rem 0.8rem; border-radius:20px; font-size:0.85rem;
      background:var(--creme); color:var(--texte);
    }

    .projet-description {
      margin-bottom:2rem;
    }
    .projet-description h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.3rem; margin-bottom:1rem;
    }
    .projet-description p {
      line-height:1.7; color:var(--texte-doux);
    }

    .projet-auteur {
      display:flex; align-items:center; gap:1rem; padding:1rem;
      background:var(--creme); border-radius:8px;
    }
    .projet-auteur-avatar {
      width:48px; height:48px; border-radius:50%; background:var(--or); color:var(--blanc);
      display:flex; align-items:center; justify-content:center; font-weight:600;
    }
    .projet-auteur-info strong {
      display:block;
    }
    .projet-auteur-info span {
      font-size:0.85rem; color:var(--texte-doux);
    }

    .status-info {
      padding:1rem; border-radius:8px; margin-top:1.5rem;
    }
    .status-info.en_attente {
      background:#FFF3CD; border:1px solid #FFEEBA; color:#856404;
    }
    .status-info.valide {
      background:#D4EDDA; border:1px solid #C3E6CB; color:#155724;
    }
    .status-info.rejete {
      background:#F8D7DA; border:1px solid #F5C6CB; color:#721C24;
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
    <a href="{{ route('entrepreneuriat.mes-projets') }}" class="back-link">
      ← Retour à mes projets
    </a>

    <div class="projet-card">
      <div class="projet-header">
        <div>
          <h1 class="projet-titre">{{ $projet->titre }}</h1>
          <span class="secteur-badge">
            @switch($projet->secteur)
              @case('agriculture_elevage') Agriculture / Élevage @break
              @case('commerce_vente') Commerce / Vente @break
              @case('artisanat') Artisanat @break
              @case('numerique_services') Numérique / Services @break
              @case('transformation_alimentaire') Transformation alimentaire @break
              @case('sante_bien_etre') Santé / Bien-être @break
              @default {{ $projet->secteur }}
            @endswitch
          </span>
        </div>
        <span class="projet-statut statut-{{ $projet->statut }}">
          @switch($projet->statut)
            @case('en_attente') En attente de validation @break
            @case('valide') Projet validé @break
            @case('rejete') Projet rejeté @break
            @default {{ $projet->statut }}
          @endswitch
        </span>
      </div>

      <div class="projet-meta">
        <div class="meta-item">
          <label>Budget estimé</label>
          <span>
            @if($projet->budget)
              {{ number_format($projet->budget, 0, ',', ' ') }} FCFA
            @else
              Non spécifié
            @endif
          </span>
        </div>
        <div class="meta-item">
          <label>Date de soumission</label>
          <span>{{ $projet->date_soumission ? $projet->date_soumission->format('d/m/Y') : $projet->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="meta-item">
          <label>Dernière mise à jour</label>
          <span>{{ $projet->updated_at->format('d/m/Y à H:i') }}</span>
        </div>
      </div>

      @if($projet->description)
        <div class="projet-description">
          <h3>Description du projet</h3>
          <p>{{ $projet->description }}</p>
        </div>
      @endif

      <div class="projet-auteur">
        <div class="projet-auteur-avatar">
          {{ strtoupper(substr($projet->user->prenom, 0, 1)) }}{{ strtoupper(substr($projet->user->nom, 0, 1)) }}
        </div>
        <div class="projet-auteur-info">
          <strong>{{ $projet->user->prenom }} {{ $projet->user->nom }}</strong>
          <span>Porteur du projet</span>
        </div>
      </div>

      <div class="status-info {{ $projet->statut }}">
        @switch($projet->statut)
          @case('en_attente')
            <strong>ℹ️ Votre projet est en cours d'examen</strong>
            <p style="margin-top:0.5rem;">Notre équipe va bientôt valider votre projet. Merci pour votre patience.</p>
            @break
          @case('valide')
            <strong>✅ Votre projet a été validé</strong>
            <p style="margin-top:0.5rem;">Félicitations ! Votre projet est maintenant visible par tous les membres de la plateforme.</p>
            @break
          @case('rejete')
            <strong>❌ Votre projet a été rejeté</strong>
            <p style="margin-top:0.5rem;">Malheureusement, votre projet ne répond pas aux critères требуés. Vous pouvez le modifier et le soumettre à nouveau.</p>
            @break
        @endswitch
      </div>
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



