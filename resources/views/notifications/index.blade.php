<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Mes notifications — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#3B1F0A; --brun-mid:#5D3A1A; --or:#C8860A; --or-clair:#D4A853; --or-pale:#F0D9B5;
      --vert:#2D6A4F; --vert-clair:#52B788;
      --blanc:#FFFFFF; --creme:#FDF6EC; --ivoire:#FAF6F0;
      --texte:#2C1810; --texte-doux:#6B5B4F;
      --gris:#9CA3AF; --gris-clair:#E5E0D8;
      --rouge:#DC2626;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Outfit', sans-serif;
      background: var(--creme);
      min-height: 100vh;
      color: var(--texte);
    }
    .layout { display: flex; min-height: 100vh; }

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
      background: var(--or-pale);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
    }
    .logo-text { display: flex; flex-direction: column; }
    .logo-name { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--brun); }
    .logo-sub { font-size: 0.7rem; color: var(--gris); text-transform: uppercase; }

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

    /* Profil Sidebar */
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
      background: linear-gradient(135deg, var(--vert), var(--vert-clair));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 700;
      color: var(--blanc);
      position: relative;
    }
    .avatar-status {
      position: absolute; bottom: 0; right: 0;
      width: 12px; height: 12px;
      background: var(--vert-clair);
      border-radius: 50%;
      border: 2px solid var(--blanc);
    }
    .profil-info { flex: 1; min-width: 0; }
    .profil-nom { font-weight: 600; font-size: 0.9rem; color: var(--texte); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .profil-role { font-size: 0.75rem; color: var(--gris); }

    /* Bouton Déconnexion */
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
      text-decoration: none;
    }
    .btn-deconnexion:hover { background: #FEE2E2; border-color: #FCA5A5; color: #DC2626; }
    .btn-deconnexion svg { width: 16px; height: 16px; }

    /* Main */
    .main { flex: 1; margin-left: 280px; display: flex; flex-direction: column; }

    /* Topbar */
    .topbar {
      height: 64px;
      background: var(--blanc);
      border-bottom: 1px solid var(--gris-clair);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .breadcrumb { font-size: 0.85rem; color: var(--gris); }
    .breadcrumb strong { color: var(--texte); font-weight: 600; }
    .topbar-droite { display: flex; align-items: center; gap: 1rem; }
    .topbar-avatar {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--vert), var(--vert-clair));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem; font-weight: 700;
      color: var(--blanc);
      border: 2px solid var(--or-pale);
    }

    /* Content */
    .content { padding: 2rem; flex: 1; }

    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
    }
    .page-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--brun);
    }
    .btn-mark-all {
      background: var(--vert);
      color: var(--blanc);
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s;
    }
    .btn-mark-all:hover { background: #1a5c3a; }
    .btn-mark-all svg { width: 16px; height: 16px; }

    /* Notifications List */
    .notifications-list {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .notification-card {
      background: var(--blanc);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      border: 1px solid var(--gris-clair);
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      transition: all 0.2s;
    }
    .notification-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .notification-card.unread {
      border-left: 4px solid var(--or);
      background: rgba(200, 134, 10, 0.03);
    }

    .notification-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .notification-icon.info { background: rgba(41,128,185,0.1); color: #2980B9; }
    .notification-icon.success { background: rgba(45,106,79,0.1); color: var(--vert); }
    .notification-icon.warning { background: rgba(200,134,10,0.1); color: var(--or); }
    .notification-icon.error { background: rgba(220,38,38,0.1); color: var(--rouge); }
    .notification-icon svg { width: 20px; height: 20px; }

    .notification-content { flex: 1; min-width: 0; }
    .notification-message {
      font-size: 0.9rem;
      color: var(--texte);
      line-height: 1.5;
      margin-bottom: 0.25rem;
    }
    .notification-time {
      font-size: 0.75rem;
      color: var(--gris);
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }
    .notification-time svg { width: 12px; height: 12px; }

    .notification-actions {
      display: flex;
      gap: 0.5rem;
      flex-shrink: 0;
    }
    .btn-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1px solid var(--gris-clair);
      background: var(--blanc);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-icon:hover { border-color: var(--vert); color: var(--vert); }
    .btn-icon.delete:hover { border-color: var(--rouge); color: var(--rouge); }
    .btn-icon svg { width: 16px; height: 16px; }

    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      background: var(--blanc);
      border-radius: 16px;
      border: 1px solid var(--gris-clair);
    }
    .empty-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 1.5rem;
      background: var(--gris-clair);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .empty-icon svg { width: 36px; height: 36px; color: var(--gris); }
    .empty-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--texte);
      margin-bottom: 0.5rem;
    }
    .empty-desc { font-size: 0.9rem; color: var(--gris); }

    /* Pagination */
    .pagination-wrap {
      margin-top: 2rem;
      display: flex;
      justify-content: center;
    }
    .pagination {
      display: flex;
      gap: 0.5rem;
    }
    .pagination a, .pagination span {
      padding: 0.5rem 0.85rem;
      border-radius: 8px;
      font-size: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
    }
    .pagination a {
      background: var(--blanc);
      border: 1px solid var(--gris-clair);
      color: var(--texte-doux);
    }
    .pagination a:hover { border-color: var(--vert); color: var(--vert); }
    .pagination span {
      background: var(--vert);
      color: var(--blanc);
      border: 1px solid var(--vert);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .main { margin-left: 0; }
      .content { padding: 1rem; }
      .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    }
  </style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  @include('partials.sidebar')

  <!-- Main -->
  <div class="main">
    <header class="topbar">
      <div class="breadcrumb">
        Plateforme Mboma &nbsp;/&nbsp; <strong>Notifications</strong>
      </div>
      <div class="topbar-droite">
        <div class="topbar-avatar">
          {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
        </div>
      </div>
    </header>

    <main class="content">
      <div class="page-header">
        <h1 class="page-title">Mes notifications</h1>
        @if($notifications->where('lu', false)->count() > 0)
        <button class="btn-mark-all" onclick="markAllAsRead()">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 11 12 14 22 4"></polyline>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
          </svg>
          Tout marquer comme lu
        </button>
        @endif
      </div>

      @if($notifications->count() > 0)
        <div class="notifications-list">
          @foreach($notifications as $notification)
            <div class="notification-card {{ $notification->lu ? '' : 'unread' }}" id="notification-{{ $notification->id }}">
              <div class="notification-icon {{ $notification->type ?? 'info' }}">
                @switch($notification->type)
                  @case('success')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                      <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    @break
                  @case('warning')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                      <line x1="12" y1="9" x2="12" y2="13"></line>
                      <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    @break
                  @case('error')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="15" y1="9" x2="9" y2="15"></line>
                      <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    @break
                  @default
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                @endswitch
              </div>

              <div class="notification-content">
                <div class="notification-message">{{ $notification->message }}</div>
                <div class="notification-time">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  {{ $notification->created_at->diffForHumans() }}
                </div>
              </div>

              <div class="notification-actions">
                @if(!$notification->lu)
                <button class="btn-icon" title="Marquer comme lu" onclick="markAsRead({{ $notification->id }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                  </svg>
                </button>
                @endif
                <button class="btn-icon delete" title="Supprimer" onclick="deleteNotification({{ $notification->id }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </div>
          @endforeach
        </div>

        <div class="pagination-wrap">
          {{ $notifications->links() }}
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
          </div>
          <h3 class="empty-title">Aucune notification</h3>
          <p class="empty-desc">Vous n'avez pas de notification pour le moment.</p>
        </div>
      @endif
    </main>
  </div>
</div>

<script>
  const CSRF_TOKEN = '{{ csrf_token() }}';

  function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById(`notification-${id}`).classList.remove('unread');
        updateHeader();
      }
    });
  }

  function markAllAsRead() {
    fetch('{{ route("notifications.read-all") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.querySelectorAll('.notification-card.unread').forEach(el => {
          el.classList.remove('unread');
        });
        document.querySelector('.btn-mark-all').style.display = 'none';
      }
    });
  }

  function deleteNotification(id) {
    if (confirm('Voulez-vous vraiment supprimer cette notification ?')) {
      fetch(`/notifications/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          document.getElementById(`notification-${id}`).remove();
        }
      });
    }
  }

  function updateHeader() {
    // Update notification count in sidebar if needed
  }
</script>

</body>
</html>

