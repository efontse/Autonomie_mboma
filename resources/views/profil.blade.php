<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mon profil — Mboma</title>
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
    .alert { padding:1rem; border-radius:8px; margin-bottom:1.5rem; }
    .alert-success { background:#D1FAE5; color:#059669; border:1px solid #A7F3D0; }
    .alert-error { background:#FEE2E2; color:#DC2626; border:1px solid #FECACA; }
    .content-grid { display:grid; grid-template-columns:1fr 1fr; gap:2rem; }
    .card { background:var(--blanc); border:1px solid var(--gris-clair); border-radius:12px; padding:1.5rem; }
    .card h2 { font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:700; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid var(--gris-clair); }
    .form-group { margin-bottom:1.25rem; }
    .form-group label { display:block; font-size:0.85rem; font-weight:600; color:var(--texte); margin-bottom:0.5rem; }
    .form-group input { width:100%; padding:0.75rem 1rem; border:1px solid var(--gris-clair); border-radius:8px; font-size:0.95rem; font-family:'Outfit',sans-serif; transition:border-color 0.2s; }
    .form-group input:focus { outline:none; border-color:var(--or); }
    .form-group input:disabled { background:var(--creme); color:var(--gris); cursor:not-allowed; }
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
    .btn-deconnexion svg { width:16px; height:16px; }
    .info-item { display:flex; justify-content:space-between; padding:0.75rem 0; border-bottom:1px solid var(--gris-clair); }
    .info-item:last-child { border-bottom:none; }
    .info-label { color:var(--texte-doux); font-size:0.9rem; }
    .info-value { font-weight:600; color:var(--texte); }
    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .sidebar { transform:translateX(-100%); } .sidebar.ouvert { transform:translateX(0); } .content-grid { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Mon profil</h1>
      </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
      {{ session('error') }}
    </div>
    @endif

    <div class="content-grid">
      <!-- Informations du profil -->
      <div class="card">
        <h2>Informations personnelles</h2>
        <form action="{{ route('profil.update') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="{{ $user->prenom }}" required>
          </div>

          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ $user->nom }}" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
          </div>

          <div class="form-group">
            <label for="role">Rôle</label>
            <input type="text" id="role" value="{{ ucfirst($user->role) }}" disabled>
          </div>

          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
      </div>

      <!-- Modifier le mot de passe -->
      <div class="card">
        <h2>Modifier le mot de passe</h2>
        <form action="{{ route('profil.password') }}" method="POST">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="mot_de_passe_actuel">Mot de passe actuel</label>
            <input type="password" id="mot_de_passe_actuel" name="mot_de_passe_actuel" required>
          </div>

          <div class="form-group">
            <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
            <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required minlength="8">
          </div>

          <div class="form-group">
            <label for="nouveau_mot_de_passe_confirmation">Confirmer le nouveau mot de passe</label>
            <input type="password" id="nouveau_mot_de_passe_confirmation" name="nouveau_mot_de_passe_confirmation" required>
          </div>

          <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
        </form>
      </div>

      <!-- Autres informations -->
      <div class="card" style="grid-column: 1 / -1;">
        <h2>Compte</h2>
        <div class="info-item">
          <span class="info-label">Membre depuis</span>
          <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Dernière connexion</span>
          <span class="info-value">{{ $user->updated_at->format('d/m/Y à H:i') }}</span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
