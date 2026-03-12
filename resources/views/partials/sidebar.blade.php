@if(Auth::user()->estAdmin())
    @include('partials.sidebar-admin')
@elseif(Auth::user()->role === 'moderateur')
    @include('partials.sidebar-moderateur')
@else
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#1C1008">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
        <path d="M12 6v6l4 2"/>
      </svg>
    </div>
    <div class="logo-text">
      <div class="logo-name">Plateforme Mboma</div>
      <div class="logo-sub">Autonomisation</div>
    </div>
  </div>

  <div class="sidebar-profil">
    <div class="avatar" id="sb-avatar">
      {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
      <div class="avatar-status"></div>
    </div>
    <div class="profil-info">
      <div class="profil-nom">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
      <div class="profil-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Principal</div>

    <a class="nav-item actif" href="{{ route('dashboard') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
      </svg>
      Tableau de bord
    </a>

    <a class="nav-item" href="{{ route('profil') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      Mon profil
    </a>

    <a class="nav-item" href="{{ route('notifications.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      Notifications
    </a>

    <div class="nav-section-label" style="margin-top:0.5rem">Modules</div>

    <a class="nav-item" href="{{ route('informations.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      Information
    </a>

    <div class="nav-item has-submenu" onclick="toggleSubmenu(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
      </svg>
      Formation
      <svg class="submenu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 12 15 18 9"/>
      </svg>
    </div>
    <div class="submenu">
      <a class="nav-item submenu-item" href="{{ route('formation.index') }}">
        Toutes les formations
      </a>
      <a class="nav-item submenu-item" href="{{ route('formation.mes-formations') }}">
        Mes formations
      </a>
    </div>

    <a class="nav-item" href="{{ route('entrepreneuriat.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="1" x2="12" y2="23"/>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
      </svg>
      Entrepreneuriat
    </a>

    <a class="nav-item" href="{{ route('communaute.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      Communauté
    </a>

    <a class="nav-item" href="{{ route('messagerie.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      Messagerie
    </a>

    @if(Auth::user()->estModerateur())
    <div class="nav-section-label" style="margin-top:0.5rem">Administration</div>
    <a class="nav-item" href="{{ route('admin.dashboard') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      Tableau de bord Admin
    </a>
    <a class="nav-item" href="{{ route('admin.utilisateurs.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
      </svg>
      Utilisateurs
    </a>
    <a class="nav-item" href="{{ route('admin.formations.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
      </svg>
      Formations
    </a>
    <a class="nav-item" href="{{ route('admin.informations.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      Informations
    </a>
    @endif
  </nav>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('auth.deconnecter') }}">
      @csrf
      <button type="submit" class="btn-deconnexion">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Déconnexion
      </button>
    </form>
  </div>
</aside>

<div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>
@endif

