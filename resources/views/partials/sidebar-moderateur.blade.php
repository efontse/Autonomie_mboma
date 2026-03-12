<aside class="sidebar" id="sidebar">
@php
function isActive($routePatterns) {
    $patterns = is_array($routePatterns) ? $routePatterns : [$routePatterns];
    foreach ($patterns as $pattern) {
        if (request()->routeIs($pattern)) {
            return true;
        }
    }
    return false;
}
@endphp
  <div class="sidebar-logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#1C1008">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
        <path d="M12 6v6l4 2"/>
      </svg>
    </div>
    <div class="logo-text">
      <div class="logo-name">Plateforme Mboma</div>
      <div class="logo-sub">Modération</div>
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
    <div class="nav-section-label">Modération</div>

    <a class="nav-item {{ isActive('admin.dashboard') ? 'actif' : '' }}" href="{{ route('admin.dashboard') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      Dashboard Modération
    </a>

    <div class="nav-section-label" style="margin-top:0.5rem">Gestion du contenu</div>

    <a class="nav-item {{ isActive('admin.formations.*') ? 'actif' : '' }}" href="{{ route('admin.formations.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
      </svg>
      Formations
    </a>

    <a class="nav-item {{ isActive('admin.informations.*') ? 'actif' : '' }}" href="{{ route('admin.informations.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      Informations
    </a>

    <div class="nav-section-label" style="margin-top:0.5rem">Modules</div>

    <a class="nav-item {{ isActive('admin.entrepreneuriat.projets.*') ? 'actif' : '' }}" href="{{ route('admin.entrepreneuriat.projets.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
      </svg>
      Projets entrepreneuriaux
    </a>

    <a class="nav-item {{ isActive('admin.entrepreneuriat.annonces.*') ? 'actif' : '' }}" href="{{ route('admin.entrepreneuriat.annonces.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
        <line x1="3" y1="9" x2="21" y2="9"/>
        <line x1="9" y1="21" x2="9" y2="9"/>
      </svg>
      Annonces
    </a>

    <div class="nav-section-label" style="margin-top:0.5rem">Mon compte</div>

    <a class="nav-item {{ isActive(['admin.profil', 'profil']) ? 'actif' : '' }}" href="{{ route('admin.profil') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      Mon profil
    </a>

    <a class="nav-item" href="#">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      Notifications
    </a>
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

<style>
.btn-deconnexion {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.6rem 0.75rem;
  background: transparent;
  border: 1px solid var(--gris-clair);
  border-radius: 6px;
  color: var(--texte-doux);
  font-size: 0.75rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
}
.btn-deconnexion:hover {
  background: #FEE2E2;
  border-color: #FCA5A5;
  color: #DC2626;
}
.btn-deconnexion svg { width: 14px; height: 14px; }
</style>

<div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>
