<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Annonce: {{ $annonce->titre }} — Admin Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root { --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0; --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68; --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E; --rouge:#DC2626; --sidebar-w:280px; }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }
    .page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair); }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .btn { display:inline-flex; align-items:center; gap:0.5rem; padding:0.6rem 1.2rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; transition:all 0.2s; cursor:pointer; border:none; }
    .btn-primary { background:var(--or); color:var(--blanc); }
    .btn-primary:hover { background:var(--brun); }
    .btn-secondary { background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair); }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }
    .btn-success { background:#D1FAE5; color:#059669; }
    .btn-success:hover { background:#059669; color:var(--blanc); }
    .btn-danger { background:#FEE2E2; color:#DC2626; }
    .btn-danger:hover { background:#DC2626; color:var(--blanc); }
    .content-grid { display:grid; grid-template-columns:2fr 1fr; gap:2rem; }
    .card { background:var(--blanc); border:1px solid var(--gris-clair); border-radius:12px; padding:1.5rem; }
    .card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid var(--gris-clair); }
    .card-header h2 { font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:700; }
    .badge { display:inline-block; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem; font-weight:600; }
    .badge-actif { background:#D1FAE5; color:#059669; }
    .badge-inactif { background:#E5E7EB; color:#6B7280; }
    .badge-produit { background:#DBEAFE; color:#2563EB; }
    .badge-service { background:#FCE7F3; color:#DB2777; }
    .detail-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem; }
    .detail-item { padding:1rem; background:var(--creme); border-radius:8px; }
    .detail-item label { display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--gris); margin-bottom:0.25rem; }
    .detail-item span { font-weight:600; }
    .description { line-height:1.7; color:var(--texte-doux); white-space:pre-wrap; }
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-clair)); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); position:relative; }
    .profil-nom { font-weight:600; font-size:0.9rem; }
    .profil-role { font-size:0.75rem; color:var(--gris); }
    .sidebar-nav { flex:1; padding:1rem 0; overflow-y:auto; }
    .nav-section-label { padding:0.5rem 1.5rem; font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; color:var(--gris); }
    .nav-item { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.5rem; color:var(--texte-doux); text-decoration:none; font-size:0.85rem; font-weight:500; transition:all 0.2s; border-left:3px solid transparent; }
    .nav-item:hover { background:var(--ivoire); color:var(--texte); }
    .nav-item.actif { background:var(--ivoire); color:var(--brun); border-left-color:var(--or); }
    .nav-item svg { width:18px; height:18px; flex-shrink:0; }
    .sidebar-footer { padding:1rem; border-top:1px solid var(--gris-clair); }
    .btn-deconnexion { width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:transparent; border:1px solid var(--gris-clair); border-radius:8px; color:var(--texte-doux); font-size:0.8rem; font-weight:500; cursor:pointer; transition:all 0.2s; text-decoration:none; }
    .btn-deconnexion:hover { background:#FEE2E2; border-color:#FCA5A5; color:#DC2626; }
    .actions-section { display:flex; flex-direction:column; gap:0.75rem; }
    .actions-section form { margin:0; }
    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .sidebar { transform:translateX(-100%); } .sidebar.ouvert { transform:translateX(0); } .content-grid { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Annonce: {{ $annonce->titre }}</h1>
      </div>
      <a href="{{ route('admin.entrepreneuriat.annonces.index') }}" class="btn btn-secondary">← Retour</a>
    </div>

    <div class="content-grid">
      <div class="card">
        <div class="card-header">
          <h2>Détails de l'annonce</h2>
          <div style="display:flex; gap:0.5rem;">
            <span class="badge badge-{{ $annonce->type }}">{{ ucfirst($annonce->type) }}</span>
            <span class="badge badge-{{ $annonce->statut }}">{{ ucfirst($annonce->statut) }}</span>
          </div>
        </div>

        <div class="detail-row">
          <div class="detail-item">
            <label>Secteur d'activité</label>
            <span>{{ $annonce->secteur }}</span>
          </div>
          <div class="detail-item">
            <label>Prix</label>
            <span>{{ $annonce->prix ? number_format($annonce->prix, 0, ',', ' ') . ' €' : 'Non défini' }}</span>
          </div>
        </div>

        <div class="detail-row">
          <div class="detail-item">
            <label>Date de création</label>
            <span>{{ $annonce->created_at->format('d/m/Y à H:i') }}</span>
          </div>
          <div class="detail-item">
            <label>Dernière modification</label>
            <span>{{ $annonce->updated_at->format('d/m/Y à H:i') }}</span>
          </div>
        </div>

        <div style="margin-top:1.5rem;">
          <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--gris); margin-bottom:0.5rem;">Description</label>
          <p class="description">{{ $annonce->description ?: 'Aucune description fournie.' }}</p>
        </div>
      </div>

      <div style="display:flex; flex-direction:column; gap:1.5rem;">
        <div class="card">
          <h3 style="font-family:'Cormorant Garamond',serif; font-size:1.25rem; margin-bottom:1rem;">Créateur</h3>
          <div class="detail-item">
            <label>Nom</label>
            <span>{{ $annonce->user->prenom ?? '' }} {{ $annonce->user->nom ?? '' }}</span>
          </div>
          <div class="detail-item" style="margin-top:0.75rem;">
            <label>Email</label>
            <span>{{ $annonce->user->email ?? '-' }}</span>
          </div>
        </div>

        <div class="card">
          <h3 style="font-family:'Cormorant Garamond',serif; font-size:1.25rem; margin-bottom:1rem;">Actions</h3>
          <div class="actions-section">
            @if($annonce->statut === 'actif')
            <form action="{{ route('admin.entrepreneuriat.annonces.desactiver', $annonce) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-secondary" style="width:100%;">⏸ Désactiver l'annonce</button>
            </form>
            @else
            <form action="{{ route('admin.entrepreneuriat.annonces.activer', $annonce) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-success" style="width:100%;">▶ Activer l'annonce</button>
            </form>
            @endif
            <hr style="border:none; border-top:1px solid var(--gris-clair); margin:0.5rem 0;">
            <form action="{{ route('admin.entrepreneuriat.annonces.destroy', $annonce) }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger" style="width:100%; background:#FEE2E2; color:#DC2626;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce? Cette action est irréversible.')">🗑 Supprimer l'annonce</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
