<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Projets entrepreneuriaux — Admin Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root { --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0; --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68; --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E; --rouge:#DC2626; --sidebar-w:280px; }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }
    .page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--gris-clair); }
    .page-header h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; }
    .stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; margin-bottom:2rem; }
    .stat-card { background:var(--blanc); border:1px solid var(--gris-clair); border-radius:12px; padding:1.5rem; }
    .stat-card h3 { font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--gris); margin-bottom:0.5rem; }
    .stat-card .value { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:700; color:var(--brun); }
    .stat-card .value.en-attente { color:#D97706; }
    .stat-card .value.approuve { color:#059669; }
    .stat-card .value.rejete { color:#DC2626; }
    .table-wrap { background:var(--blanc); border-radius:12px; border:1px solid var(--gris-clair); overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:1rem; text-align:left; border-bottom:1px solid var(--gris-clair); }
    th { background:var(--creme); font-weight:600; font-size:0.85rem; }
    td { font-size:0.9rem; }
    tr:last-child td { border-bottom:none; }
    tr:hover { background:var(--creme); }
    .badge { display:inline-block; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem; font-weight:600; }
    .badge-en-attente { background:#FEF3C7; color:#D97706; }
    .badge-approuve { background:#D1FAE5; color:#059669; }
    .badge-rejete { background:#FEE2E2; color:#DC2626; }
    .actions { display:flex; gap:0.5rem; }
    .btn-action { padding:0.4rem 0.8rem; border-radius:6px; font-size:0.8rem; text-decoration:none; border:1px solid var(--gris-clair); background:var(--blanc); color:var(--texte-doux); cursor:pointer; }
    .btn-action:hover { border-color:var(--or); color:var(--or); }
    .btn-danger { color:var(--rouge); }
    .btn-danger:hover { border-color:var(--rouge); background:#FEE2E2; }
    .btn-success { color:#059669; }
    .btn-success:hover { border-color:#059669; background:#D1FAE5; }
    .btn-warning { color:#D97706; }
    .btn-warning:hover { border-color:#D97706; background:#FEF3C7; }
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
    @media (max-width:900px) { .page-wrap { margin-left:0; padding:1.5rem; } .sidebar { transform:translateX(-100%); } .sidebar.ouvert { transform:translateX(0); } .stats-row { grid-template-columns:repeat(2,1fr); } }
  </style>
</head>
<body>
  @include('partials.sidebar')

  <div class="page-wrap">
    <div class="page-header">
      <div>
        <h1>Projets entrepreneuriaux</h1>
      </div>
    </div>

    @php
    $totalProjets = $projets->total();
    $enAttente = \App\Models\ProjetEntrepreneurial::where('statut', 'en_attente')->count();
    $approuves = \App\Models\ProjetEntrepreneurial::where('statut', 'approuve')->count();
    $rejetes = \App\Models\ProjetEntrepreneurial::where('statut', 'rejete')->count();
    @endphp

    <div class="stats-row">
      <div class="stat-card">
        <h3>Total</h3>
        <div class="value">{{ $totalProjets }}</div>
      </div>
      <div class="stat-card">
        <h3>En attente</h3>
        <div class="value en-attente">{{ $enAttente }}</div>
      </div>
      <div class="stat-card">
        <h3>Approuvés</h3>
        <div class="value approuve">{{ $approuves }}</div>
      </div>
      <div class="stat-card">
        <h3>Rejetés</h3>
        <div class="value rejete">{{ $rejetes }}</div>
      </div>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Titre</th>
            <th>Secteur</th>
            <th>Porteur</th>
            <th>Budget</th>
            <th>Soumis le</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projets as $projet)
          <tr>
            <td><strong>{{ $projet->titre }}</strong></td>
            <td>{{ $projet->secteur }}</td>
            <td>{{ $projet->user->prenom ?? '' }} {{ $projet->user->nom ?? '' }}</td>
            <td>{{ $projet->budget ? number_format($projet->budget, 0, ',', ' ') . ' €' : '-' }}</td>
            <td>{{ $projet->date_soumission ? $projet->date_soumission->format('d/m/Y') : '-' }}</td>
            <td><span class="badge badge-{{ $projet->statut }}">{{ ucfirst(str_replace('_', ' ', $projet->statut)) }}</span></td>
            <td class="actions">
              <a href="{{ route('admin.entrepreneuriat.projets.show', $projet) }}" class="btn-action">Voir</a>
              @if($projet->statut === 'en_attente')
              <form action="{{ route('admin.entrepreneuriat.projets.approuver', $projet) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn-action btn-success" title="Approuver">✓</button>
              </form>
              <form action="{{ route('admin.entrepreneuriat.projets.rejeter', $projet) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn-action btn-danger" title="Rejeter" onclick="return confirm('Voulez-vous vraiment rejeter ce projet?')">✗</button>
              </form>
              @elseif($projet->statut === 'approuve')
              <form action="{{ route('admin.entrepreneuriat.projets.attendre', $projet) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn-action btn-warning" title="Remettre en attente">↺</button>
              </form>
              @elseif($projet->statut === 'rejete')
              <form action="{{ route('admin.entrepreneuriat.projets.approuver', $projet) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn-action btn-success" title="Approuver">✓</button>
              </form>
              @endif
              <form action="{{ route('admin.entrepreneuriat.projets.destroy', $projet) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet?')">🗑</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center; padding:2rem;">Aucun projet trouvé</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{ $projets->links() }}
  </div>
</body>
</html>
