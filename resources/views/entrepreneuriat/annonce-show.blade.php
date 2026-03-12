<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $annonce->titre }} — Plateforme Mboma</title>
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

    .annonce-card {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      padding:2rem; max-width:800px;
    }

    .annonce-header {
      display:flex; justify-content:space-between; align-items:flex-start;
      margin-bottom:1.5rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair);
    }

    .annonce-titre {
      font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700;
      color:var(--brun); margin-bottom:0.5rem;
    }

    .annonce-badges {
      display:flex; gap:0.5rem;
    }

    .annonce-type {
      padding:0.4rem 1rem; border-radius:4px; font-size:0.85rem; font-weight:600;
    }
    .type-produit { background:#D4EDDA; color:#155724; }
    .type-service { background:#CCE5FF; color:#004085; }

    .annonce-statut {
      padding:0.4rem 1rem; border-radius:4px; font-size:0.85rem;
    }
    .statut-actif { background:#D4EDDA; color:#155724; }
    .statut-inactif { background:#E8E2D8; color:#6B5B4E; }

    .annonce-meta {
      display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.5rem;
      margin-bottom:2rem;
    }

    .meta-item label {
      display:block; font-size:0.8rem; color:var(--texte-doux); margin-bottom:0.3rem;
    }
    .meta-item span { font-weight:500; }

    .secteur-badge {
      display:inline-block; padding:0.3rem 0.8rem; border-radius:20px; font-size:0.85rem;
      background:var(--creme); color:var(--texte);
    }

    .annonce-prix {
      font-size:1.8rem; font-weight:700; color:var(--or); margin:1.5rem 0;
    }

    .annonce-description {
      margin-bottom:2rem;
    }
    .annonce-description h3 {
      font-family:'Cormorant Garamond',serif; font-size:1.3rem; margin-bottom:1rem;
    }
    .annonce-description p {
      line-height:1.7; color:var(--texte-doux); white-space:pre-wrap;
    }

    .annonce-auteur {
      display:flex; align-items:center; gap:1rem; padding:1rem;
      background:var(--creme); border-radius:8px;
    }
    .annonce-auteur-avatar {
      width:48px; height:48px; border-radius:50%; background:var(--or); color:var(--blanc);
      display:flex; align-items:center; justify-content:center; font-weight:600;
    }
    .annonce-auteur-info strong { display:block; }
    .annonce-auteur-info span { font-size:0.85rem; color:var(--texte-doux); }

    .btn {
      padding:0.7rem 1.4rem; border-radius:8px; font-size:0.9rem; font-weight:500;
      text-decoration:none; cursor:pointer; border:none; transition:all 0.2s;
      display:inline-flex; align-items:center; gap:0.5rem;
    }
    .btn-secondary { background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair); }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }
    .btn-danger { background:#F8D7DA; color:#721C24; border:1px solid #F5C6CB; }
    .btn-danger:hover { background:#F5C6CB; }

    .annonce-actions {
      display:flex; gap:1rem; margin-top:1.5rem; padding-top:1.5rem;
      border-top:1px solid var(--gris-clair);
    }

    .nav-item svg { width:18px; height:18px; flex-shrink:0; }
    .nav-item.actif { background:var(--ivoire); color:var(--brun); border-left-color:var(--or); }

    /* Sidebar Complet */
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .logo-text { display:flex; flex-direction:column; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-clair)); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); position:relative; }
    .avatar-status { position:absolute; bottom:0; right:0; width:12px; height:12px; background:var(--vert-clair); border-radius:50%; border:2px solid var(--blanc); }
    .profil-info { flex:1; min-width:0; }
    .profil-nom { font-weight:600; font-size:0.9rem; color:var(--texte); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .profil-role { font-size:0.75rem; color:var(--gris); }
    .sidebar-nav { flex:1; padding:1rem 0; overflow-y:auto; }
    .nav-section-label { padding:0.5rem 1.5rem; font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; color:var(--gris); }
    .nav-item { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.5rem; color:var(--texte-doux); text-decoration:none; font-size:0.85rem; font-weight:500; transition:all 0.2s; border-left:3px solid transparent; }
    .nav-item:hover { background:var(--ivoire); color:var(--texte); }
    .sidebar-footer { padding:1rem; border-top:1px solid var(--gris-clair); }
    .btn-deconnexion { width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:transparent; border:1px solid var(--gris-clair); border-radius:8px; color:var(--texte-doux); font-size:0.8rem; font-weight:500; cursor:pointer; transition:all 0.2s; text-decoration:none; }
    .btn-deconnexion:hover { background:#FEE2E2; border-color:#FCA5A5; color:#DC2626; }
    .btn-deconnexion svg { width:16px; height:16px; }
    .menu-toggle { background:none; border:none; cursor:pointer; padding:0.5rem; display:none; }
    .menu-toggle svg { width:24px; height:24px; stroke:var(--texte); }

    @media (max-width:900px) {
      .page-wrap { margin-left:0; padding:1.5rem; }
      .sidebar { transform:translateX(-100%); }
      .sidebar.ouvert { transform:translateX(0); }
      .menu-toggle { display:block; }
    }
  </style>
</head>
<body>
  <div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>@include('partials.sidebar')

  <div class="page-wrap">
    <a href="{{ route('entrepreneuriat.mes-annonces') }}" class="back-link">
      ← Retour à mes annonces
    </a>

    <div class="annonce-card">
      <div class="annonce-header">
        <div>
          <h1 class="annonce-titre">{{ $annonce->titre }}</h1>
          <div class="annonce-badges" style="margin-top:0.5rem;">
            <span class="secteur-badge">
              @switch($annonce->secteur)
                @case('agriculture_elevage') Agriculture / Élevage @break
                @case('commerce_vente') Commerce / Vente @break
                @case('artisanat') Artisanat @break
                @case('numerique_services') Numérique / Services @break
                @case('transformation_alimentaire') Transformation alimentaire @break
                @case('sante_bien_etre') Santé / Bien-être @break
                @default {{ $annonce->secteur }}
              @endswitch
            </span>
            <span class="annonce-type type-{{ $annonce->type }}">
              {{ $annonce->type === 'produit' ? 'Produit' : 'Service' }}
            </span>
          </div>
        </div>
        <span class="annonce-statut statut-{{ $annonce->statut }}">
          {{ $annonce->statut === 'actif' ? 'Active' : 'Inactive' }}
        </span>
      </div>

      @if($annonce->prix)
        <p class="annonce-prix">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>
      @endif

      <div class="annonce-meta">
        <div class="meta-item">
          <label>Date de publication</label>
          <span>{{ $annonce->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="meta-item">
          <label>Dernière modification</label>
          <span>{{ $annonce->updated_at->format('d/m/Y à H:i') }}</span>
        </div>
      </div>

      @if($annonce->description)
        <div class="annonce-description">
          <h3>Description</h3>
          <p>{{ $annonce->description }}</p>
        </div>
      @endif

      <div class="annonce-auteur">
        <div class="annonce-auteur-avatar">
          {{ strtoupper(substr($annonce->user->prenom, 0, 1)) }}{{ strtoupper(substr($annonce->user->nom, 0, 1)) }}
        </div>
        <div class="annonce-auteur-info">
          <strong>{{ $annonce->user->prenom }} {{ $annonce->user->nom }}</strong>
          <span>Annonceur</span>
        </div>
      </div>

      <div class="annonce-actions">
        <form action="{{ route('entrepreneuriat.annonce.toggle', $annonce) }}" method="POST">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-secondary">
            {{ $annonce->statut === 'actif' ? 'Désactiver' : 'Activer' }}
          </button>
        </form>
        <form action="{{ route('entrepreneuriat.annonce.destroy', $annonce) }}" method="POST"
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>



