<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catégories — Admin Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root { --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0; --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68; --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E; --rouge:#DC2626; --sidebar-w:280px; }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }
    .page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair); }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .form-card { background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair); padding:1.5rem; margin-bottom:2rem; }
    .form-group { margin-bottom:1rem; }
    .form-group label { display:block; font-size:0.85rem; font-weight:500; margin-bottom:0.5rem; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:0.75rem; border:1px solid var(--gris-clair); border-radius:8px; font-size:0.9rem; font-family:inherit; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:var(--or); }
    .btn { display:inline-flex; align-items:center; gap:0.5rem; padding:0.6rem 1.2rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; }
    .btn-primary { background:var(--or); color:var(--blanc); }
    .btn-primary:hover { background:var(--brun); }
    .table-wrap { background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair); overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:1rem; text-align:left; border-bottom:1px solid var(--gris-clair); }
    th { background:var(--creme); font-weight:600; font-size:0.85rem; }
    tr:last-child td { border-bottom:none; }
    .categorie-couleur { width:24px; height:24px; border-radius:6px; display:inline-block; }
    .actions { display:flex; gap:0.5rem; }
    .btn-action { padding:0.4rem 0.8rem; border-radius:6px; font-size:0.8rem; text-decoration:none; border:1px solid var(--gris-clair); background:var(--blanc); color:var(--texte-doux); cursor:pointer; }
    .btn-action:hover { border-color:var(--or); color:var(--or); }
    .btn-danger { color:var(--rouge); }
    .btn-danger:hover { border-color:var(--rouge); background:#FEE2E2; }
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-clair)); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); }
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
    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .sidebar { transform:translateX(-100%); } .sidebar.ouvert { transform:translateX(0); } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Catégories de formations</h1>
      </div>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="form-card">
      <h3 style="margin-bottom:1rem;">Ajouter une catégorie</h3>
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:1rem; align-items:end;">
          <div class="form-group" style="margin-bottom:0;">
            <label>Nom</label>
            <input type="text" name="nom" required placeholder="Nom de la catégorie">
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label>Couleur</label>
            <input type="color" name="couleur" value="#C9923A">
          </div>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>

    <!-- Liste des catégories -->
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Couleur</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Formations</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $categorie)
          <tr>
            <td><span class="categorie-couleur" style="background: {{ $categorie->couleur }}"></span></td>
            <td><strong>{{ $categorie->nom }}</strong></td>
            <td>{{ $categorie->description ?? '-' }}</td>
            <td>{{ $categorie->formations()->count() }}</td>
            <td class="actions">
              <form action="{{ route('admin.categories.destroy', $categorie) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action btn-danger" onclick="return confirm('Êtes-vous sûr?')" {{ $categorie->formations()->count() > 0 ? 'disabled' : '' }}>Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center; padding:2rem;">Aucune catégorie trouvée</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
