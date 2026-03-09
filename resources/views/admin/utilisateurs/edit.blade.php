<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modifier utilisateur — Admin Mboma</title>
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
    .header-actions { display:flex; gap:0.75rem; }

    .btn {
      display:inline-flex; align-items:center; gap:0.5rem;
      padding:0.6rem 1.2rem; border-radius:8px; font-size:0.85rem; font-weight:500;
      text-decoration:none; transition:all 0.2s;
    }
    .btn-primary { background:var(--or); color:var(--blanc); border:none; cursor:pointer; }
    .btn-primary:hover { background:var(--brun); }
    .btn-secondary { background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair); }
    .btn-secondary:hover { border-color:var(--or); color:var(--or); }

    .card {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      padding:2rem;
    }

    .form-grid {
      display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));
      gap:1.5rem;
    }
    .form-group { margin-bottom:1.25rem; }
    .form-label {
      display:block; font-size:0.85rem; font-weight:600; color:var(--texte);
      margin-bottom:0.5rem;
    }
    .form-input, .form-select {
      width:100%; padding:0.75rem 1rem; border:1px solid var(--gris-clair);
      border-radius:8px; font-size:0.95rem; font-family:'Outfit',sans-serif;
      transition:border-color 0.2s;
    }
    .form-input:focus, .form-select:focus {
      outline:none; border-color:var(--or);
    }
    .form-hint { font-size:0.75rem; color:var(--gris); margin-top:0.25rem; }

    .role-cards {
      display:grid; grid-template-columns:repeat(3, 1fr);
      gap:1rem;
      margin-top:0.5rem;
    }
    .role-card {
      padding:1rem; border:2px solid var(--gris-clair); border-radius:8px;
      cursor:pointer; transition:all 0.2s; text-align:center;
    }
    .role-card:hover { border-color:var(--or-clair); }
    .role-card.selected { border-color:var(--or); background:var(--creme); }
    .role-card-title { font-weight:600; font-size:0.95rem; margin-bottom:0.25rem; }
    .role-card-desc { font-size:0.75rem; color:var(--texte-doux); }

    .form-actions {
      margin-top:2rem; padding-top:1.5rem;
      border-top:1px solid var(--gris-clair);
      display:flex; gap:1rem; justify-content:flex-end;
    }

    /* Sidebar */
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .sidebar-avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-clair)); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); position:relative; }
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
        <h1>Modifier l'utilisateur</h1>
      </div>
      <div class="header-actions">
        <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">← Retour</a>
      </div>
    </div>

    <div class="card">
      <form action="{{ route('admin.utilisateurs.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
          <div class="form-group">
            <label class="form-label" for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-input" value="{{ old('prenom', $user->prenom) }}" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-input" value="{{ old('nom', $user->nom) }}" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-input" value="{{ old('telephone', $user->telephone) }}">
          </div>

          <div class="form-group">
            <label class="form-label" for="quartier">Quartier</label>
            <input type="text" id="quartier" name="quartier" class="form-input" value="{{ old('quartier', $user->quartier) }}">
          </div>

          <div class="form-group">
            <label class="form-label" for="village">Village</label>
            <input type="text" id="village" name="village" class="form-input" value="{{ old('village', $user->village) }}">
          </div>

          <div class="form-group">
            <label class="form-label" for="statut">Statut</label>
            <select id="statut" name="statut" class="form-select">
              <option value="actif" {{ old('statut', $user->statut) === 'actif' ? 'selected' : '' }}>Actif</option>
              <option value="inactif" {{ old('statut', $user->statut) === 'inactif' ? 'selected' : '' }}>Inactif</option>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-top:1.5rem">
          <label class="form-label">Rôle de l'utilisateur</label>
          <div class="role-cards">
            <label class="role-card {{ old('role', $user->role) === 'utilisateur' ? 'selected' : '' }}">
              <input type="radio" name="role" value="utilisateur" {{ old('role', $user->role) === 'utilisateur' ? 'checked' : '' }} style="display:none">
              <div class="role-card-title">Utilisateur</div>
              <div class="role-card-desc">Accès standard à la plateforme</div>
            </label>
            <label class="role-card {{ old('role', $user->role) === 'moderateur' ? 'selected' : '' }}">
              <input type="radio" name="role" value="moderateur" {{ old('role', $user->role) === 'moderateur' ? 'checked' : '' }} style="display:none">
              <div class="role-card-title">Modérateur</div>
              <div class="role-card-desc">Gestion du contenu</div>
            </label>
            <label class="role-card {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}">
              <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} style="display:none">
              <div class="role-card-title">Administrateur</div>
              <div class="role-card-desc">Accès complet</div>
            </label>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.querySelectorAll('.role-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
      });
    });
  </script>
</body>
</html>
