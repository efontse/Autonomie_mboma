<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Annonces — Plateforme Mboma</title>
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

    .filtres { display:flex; gap:0.8rem; margin-bottom:2rem; flex-wrap:wrap; }
    .filtre {
      padding:0.5rem 1rem; border-radius:8px; font-size:0.82rem; font-weight:500;
      border:1px solid var(--gris-clair); background:var(--blanc); color:var(--texte-doux);
      cursor:pointer; transition:all 0.2s;
    }
    .filtre:hover, .filtre.actif {
      border-color:var(--or); color:var(--or); background:rgba(201,146,58,0.08);
    }

    .annonces-grid {
      display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1.5rem;
    }
    .annonce-card {
      background:var(--blanc); border-radius:16px; border:1px solid var(--gris-clair);
      overflow:hidden; transition:all 0.3s;
    }
    .annonce-card:hover {
      transform:translateY(-4px); box-shadow:0 12px 32px rgba(28,16,8,0.1);
    }
    .annonce-header {
      padding:1rem 1.5rem; border-bottom:1px solid var(--gris-clair);
      display:flex; justify-content:space-between; align-items:center;
    }
    .annonce-type {
      padding:0.25rem 0.6rem; border-radius:4px; font-size:0.75rem; font-weight:600;
    }
    .type-produit { background:#D4EDDA; color:#155724; }
    .type-service { background:#CCE5FF; color:#004085; }

    .annonce-body { padding:1.5rem; }
    .annonce-secteur {
      display:inline-block; padding:0.3rem 0.8rem; border-radius:20px;
      font-size:0.75rem; background:var(--creme); color:var(--texte-doux); margin-bottom:0.8rem;
    }
    .annonce-titre {
      font-family:'Cormorant Garamond',serif; font-size:1.3rem; font-weight:700;
      margin-bottom:0.5rem;
    }
    .annonce-prix {
      font-size:1.1rem; font-weight:600; color:var(--or); margin-bottom:0.5rem;
    }
    .annonce-desc {
      font-size:0.85rem; color:var(--texte-doux); line-height:1.5;
      display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .annonce-footer {
      padding:1rem 1.5rem; border-top:1px solid var(--gris-clair);
      display:flex; justify-content:space-between; align-items:center;
    }
    .annonce-auteur { font-size:0.85rem; color:var(--texte-doux); }
    .annonce-date { font-size:0.8rem; color:var(--gris); }

    .empty-state {
      text-align:center; padding:4rem 2rem; background:var(--blanc); border-radius:16px;
      border:1px dashed var(--gris-clair);
    }
    .empty-state h3 { font-family:'Cormorant Garamond',serif; font-size:1.5rem; margin-bottom:0.5rem; }
    .empty-state p { color:var(--texte-doux); }

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
    <a href="{{ route('entrepreneuriat.index') }}" class="back-link">
      ← Retour au module entrepreneuriat
    </a>

    <button class="menu-toggle" onclick="toggleSidebar()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button><div class="page-header">
      <div>
        <h1>Annonces de produits et services</h1>
        <p>Découvrez les produits et services proposés par la communauté</p>
      </div>
    </div>

    @if($annonces->count() > 0)
      <div class="annonces-grid">
        @foreach($annonces as $annonce)
          <div class="annonce-card">
            <div class="annonce-header">
              <span class="annonce-type type-{{ $annonce->type }}">
                {{ $annonce->type === 'produit' ? 'Produit' : 'Service' }}
              </span>
            </div>
            <div class="annonce-body">
              <span class="annonce-secteur">
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
              <h3 class="annonce-titre">{{ $annonce->titre }}</h3>
              @if($annonce->prix)
                <p class="annonce-prix">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>
              @endif
              @if($annonce->description)
                <p class="annonce-desc">{{ $annonce->description }}</p>
              @endif
            </div>
            <div class="annonce-footer">
              <span class="annonce-auteur">{{ $annonce->user->prenom }} {{ $annonce->user->nom }}</span>
              <span class="annonce-date">{{ $annonce->created_at->format('d/m/Y') }}</span>
            </div>
          </div>
        @endforeach
      </div>

      <div style="margin-top:2rem;">
        {{ $annonces->links() }}
      </div>
    @else
      <div class="empty-state">
        <h3>Aucune annonce disponible</h3>
        <p>Soyez le premier à publier une annonce !</p>
      </div>
    @endif
  </div>
</body>
</html>



