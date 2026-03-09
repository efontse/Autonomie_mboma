<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Utilisateurs — Admin Mboma</title>
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

    .btn {
      display:inline-flex; align-items:center; gap:0.5rem;
      padding:0.6rem 1.2rem; border-radius:8px; font-size:0.85rem; font-weight:500;
      text-decoration:none; transition:all 0.2s;
    }
    .btn-primary { background:var(--or); color:var(--blanc); border:none; }
    .btn-primary:hover { background:var(--brun); }

    .table-wrap {
      background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair);
      overflow:hidden;
    }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:1rem; text-align:left; border-bottom:1px solid var(--gris-clair); }
    th { background:var(--creme); font-weight:600; font-size:0.85rem; }
    td { font-size:0.9rem; }
    tr:last-child td { border-bottom:none; }
    tr:hover { background:var(--creme); }

    .badge {
      display:inline-block; padding:0.25rem 0.5rem; border-radius:4px;
      font-size:0.75rem; font-weight:600;
    }
    .badge-admin { background:#FEE2E2; color:#DC2626; }
    .badge-mod { background:#DBEAFE; color:#2563EB; }
    .badge-user { background:#D1FAE5; color:#059669; }

    .actions { display:flex; gap:0.5rem; }
    .btn-action {
      padding:0.4rem 0.8rem; border-radius:6px; font-size:0.8rem;
      text-decoration:none; border:1px solid var(--gris-clair);
      background:var(--blanc); color:var(--texte-doux); cursor:pointer;
    }
    .btn-action:hover { border-color:var(--or); color:var(--or); }
    .btn-danger { color:var(--rouge); }
    .btn-danger:hover { border-color:var(--rouge); background:#FEE2E2; }

    /* Modal de confirmation */
    .modal-overlay {
      display:none; position:fixed; top:0; left:0; right:0; bottom:0;
      background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;
    }
    .modal-overlay.active { display:flex; }
    .modal-card {
      background:var(--blanc); border-radius:12px; padding:2rem; max-width:400px; width:90%;
      box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);
    }
    .modal-icon {
      width:60px; height:60px; background:#FEE2E2; border-radius:50%; display:flex;
      align-items:center; justify-content:center; margin:0 auto 1.5rem;
    }
    .modal-icon svg { width:30px; height:30px; color:var(--rouge); }
    .modal-title { font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:700; text-align:center; margin-bottom:0.5rem; }
    .modal-text { text-align:center; color:var(--texte-doux); font-size:0.95rem; margin-bottom:1.5rem; }
    .modal-actions { display:flex; gap:1rem; justify-content:center; }
    .btn-cancel { background:var(--blanc); color:var(--texte); border:1px solid var(--gris-clair); }
    .btn-cancel:hover { border-color:var(--or); color:var(--or); }
    .btn-delete { background:var(--rouge); color:var(--blanc); border:none; }
    .btn-delete:hover { background:#B91C1C; }

    /* Sidebar */
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

    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .sidebar { transform:translateX(-100%); } .sidebar.ouvert { transform:translateX(0); } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Gestion des utilisateurs</h1>
      </div>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Utilisateur</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
            <th>Dernière connexion</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
          <tr>
            <td>
              <strong>{{ $user->prenom }} {{ $user->nom }}</strong><br>
              <small style="color:var(--gris)">{{ $user->email }}</small>
            </td>
            <td>
              <span class="badge badge-{{ $user->role === 'admin' ? 'admin' : ($user->role === 'moderateur' ? 'mod' : 'user') }}">
                {{ ucfirst($user->role) }}
              </span>
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>{{ $user->derniere_connexion ? $user->derniere_connexion->format('d/m/Y H:i') : '-' }}</td>
            <td class="actions">
              <a href="{{ route('admin.utilisateurs.show', $user) }}" class="btn-action">Voir</a>
              <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="btn-action">Éditer</a>
              <button type="button" class="btn-action btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->prenom) }} {{ addslashes($user->nom) }}')">Supprimer</button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center; padding:2rem;">Aucun utilisateur trouvé</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{ $users->links() }}
  </div>

  <!-- Modal de confirmation de suppression -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-card">
      <div class="modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        </svg>
      </div>
      <h3 class="modal-title">Confirmer la suppression</h3>
      <p class="modal-text">Êtes-vous sûr de vouloir supprimer l'utilisateur <strong id="deleteUserName"></strong> ? Cette action est irréversible.</p>
      <div class="modal-actions">
        <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Annuler</button>
        <form id="deleteForm" method="POST" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-delete">Supprimer</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(userId, userName) {
      document.getElementById('deleteUserName').textContent = userName;
      document.getElementById('deleteForm').action = '/admin/utilisateurs/' + userId;
      document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('active');
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) closeDeleteModal();
    });
  </script>
</body>
</html>
