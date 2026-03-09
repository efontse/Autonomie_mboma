<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nouvelle formation — Admin Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root { --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0; --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68; --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E; --rouge:#DC2626; --sidebar-w:280px; }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }
    .page-header { margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair); }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .form-card { background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair); padding:2rem; max-width:800px; }
    .form-group { margin-bottom:1.5rem; }
    .form-group label { display:block; font-size:0.9rem; font-weight:500; margin-bottom:0.5rem; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:0.75rem; border:1px solid var(--gris-clair); border-radius:8px; font-size:0.95rem; font-family:inherit; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:var(--or); }
    .form-group textarea { min-height:150px; resize:vertical; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .btn { display:inline-flex; align-items:center; gap:0.5rem; padding:0.75rem 1.5rem; border-radius:8px; font-size:0.9rem; font-weight:500; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; }
    .btn-primary { background:var(--or); color:var(--blanc); }
    .btn-primary:hover { background:var(--brun); }
    .btn-secondary { background:transparent; border:1px solid var(--gris-clair); color:var(--texte-doux); }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-clair)); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); }
    .profil-nom { font-weight:600; font-size:0.9rem; }
    .profil-role { font-size:0.75rem; color:var(--gris); }
    .sidebar-nav { flex:1; padding:1rem 0; overflow-y:auto; }
    .nav-section-label { padding:0.5rem 1.5rem; font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; color:var(--gris); }
    .nav-item { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.5rem; color:var(--texte-doux); text-decoration:none; font-size:0.85rem; font-weight:500; border-left:3px solid transparent; }
    .nav-item:hover { background:var(--ivoire); color:var(--texte); }
    .nav-item.actif { background:var(--ivoire); color:var(--brun); border-left-color:var(--or); }
    .nav-item svg { width:18px; height:18px; }
    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .form-row { grid-template-columns:1fr; } .sidebar { transform:translateX(-100%); } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <h1>Nouvelle formation</h1>
    </div>

    <div class="form-card">
      <form action="{{ route('admin.formations.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label>Titre</label>
          <input type="text" name="titre" required>
        </div>

        <div class="form-group">
          <label>Catégorie</label>
          <select name="categorie_id" required>
            <option value="">Sélectionner une catégorie</option>
            @foreach($categories as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Type</label>
            <select name="type" required>
              <option value="video">Vidéo</option>
              <option value="document">Document</option>
              <option value="article">Article</option>
              <option value="mixte">Mixte</option>
            </select>
          </div>

          <div class="form-group">
            <label>Niveau</label>
            <select name="niveau" required>
              <option value="debutant">Débutant</option>
              <option value="intermediaire">Intermédiaire</option>
              <option value="avance">Avancé</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Durée (minutes)</label>
            <input type="number" name="duree_minutes" required min="1">
          </div>

          <div class="form-group">
            <label>URL Vidéo (YouTube)</label>
            <input type="url" name="video_url" placeholder="https://youtube.com/...">
          </div>
        </div>

        <div class="form-group">
          <label>URL Image</label>
          <input type="url" name="image_url" placeholder="https://...">
        </div>

        <div class="form-group">
          <label>Description courte</label>
          <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
          <label>Contenu complet</label>
          <textarea name="contenu" required style="min-height:300px;"></textarea>
        </div>

        <div style="display:flex; gap:1rem;">
          <button type="submit" class="btn btn-primary">Créer la formation</button>
          <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
