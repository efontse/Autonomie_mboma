<?php
// ============================================================
// resources/views/Information index.blade.php
// Page d'affichage de la liste des informations
// ============================================================

use App\Models\Information;
use App\Models\User;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Informations - Mboma Platform</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --terre: #8B4513;
      --savane: #C8860A;
      --ocre: #D4A853;
      --vert: #2D5A3D;
      --vert-clair: #4A7C5C;
      --blanc: #FFFFFF;
      --gris: #6B6B6B;
      --gris-clair: #F5F3EF;
      --rouge: #E74C3C;
      --bleu: #2980B9;
    }

    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gris-clair);
      min-height: 100vh;
    }

    /* Header */
    .header {
      background: linear-gradient(160deg, var(--vert) 0%, #1a4030 60%);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .header-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      color: var(--blanc);
    }

    .header-nav {
      display: flex;
      gap: 1.5rem;
      align-items: center;
    }

    .header-link {
      color: var(--blanc);
      text-decoration: none;
      font-weight: 500;
      opacity: 0.9;
      transition: opacity 0.2s;
    }

    .header-link:hover {
      opacity: 1;
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--blanc);
    }

    /* Main container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    /* Page header */
    .page-header {
      margin-bottom: 2rem;
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      color: var(--terre);
      margin-bottom: 0.5rem;
    }

    .page-subtitle {
      color: var(--gris);
      font-size: 1rem;
    }

    /* Filters */
    .filters {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .filter-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 20px;
      background: var(--blanc);
      color: var(--gris);
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .filter-btn:hover,
    .filter-btn.active {
      background: var(--vert);
      color: var(--blanc);
    }

    /* Articles grid */
    .articles-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 1.5rem;
    }

    .article-card {
      background: var(--blanc);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .article-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .article-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      background: linear-gradient(135deg, var(--vert-clair) 0%, var(--vert) 100%);
    }

    .article-content {
      padding: 1.25rem;
    }

    .article-category {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--blanc);
      margin-bottom: 0.75rem;
      background-color: #888888;
    }

    .article-category[data-color] {
      background-color: var(--color);
    }

    .article-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.125rem;
      color: #333;
      margin-bottom: 0.5rem;
      line-height: 1.4;
    }

    .article-excerpt {
      color: var(--gris);
      font-size: 0.875rem;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .article-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.8rem;
      color: var(--gris);
      border-top: 1px solid var(--gris-clair);
      padding-top: 0.75rem;
    }

    .article-author {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .article-stats {
      display: flex;
      gap: 1rem;
    }

    .stat-item {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: var(--gris);
    }

    .empty-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .empty-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      color: #333;
      margin-bottom: 0.5rem;
    }

    /* Alert messages */
    .alert {
      padding: 1rem 1.25rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
    }

    .alert-success {
      background: #D4EDDA;
      color: #155724;
      border: 1px solid #C3E6CB;
    }

    .alert-error {
      background: #F8D7DA;
      color: #721C24;
      border: 1px solid #F5C6CB;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .articles-grid {
        grid-template-columns: 1fr;
      }

      .container {
        padding: 1rem;
      }

      .header {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="header-logo">Mboma Platform</div>
    <nav class="header-nav">
      <a href="{{ route('dashboard') }}" class="header-link">Tableau de bord</a>
      <a href="#" class="header-link">Informations</a>
      <a href="#" class="header-link">Formations</a>
      <div class="header-user">
        <span>{{ Auth::user()->prenom ?? 'Utilisateur' }}</span>
      </div>
    </nav>
  </header>

  <!-- Main content -->
  <main class="container">
    <div class="page-header">
      <h1 class="page-title">Nos Informations</h1>
      <p class="page-subtitle">Restez informé des dernières nouvelles et actualité</p>
    </div>

    <!-- Category filters -->
    <div class="filters">
      <button class="filter-btn active" data-category="all">Toutes</button>
      @foreach(Information::categories() as $key => $cat)
        <button class="filter-btn" data-category="{{ $key }}">{{ $cat['label'] }}</button>
      @endforeach
    </div>

    <!-- Articles grid -->
    <div class="articles-grid">
      @forelse($informations ?? [] as $information)
        <article class="article-card">
          @if($information->image_url)
            <img src="{{ asset($information->image_url) }}" alt="{{ $information->titre }}" class="article-image">
          @else
            <div class="article-image" style="display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
              📰
            </div>
          @endif

          <div class="article-content">
            <span class="article-category" style="--color: {{ $information->categorieCouleur() }}">
              {{ $information->categorieLabel() }}
            </span>

            <h2 class="article-title">{{ $information->titre }}</h2>
            <p class="article-excerpt">{{ $information->extrait(120) }}</p>

            <div class="article-meta">
              <div class="article-author">
                <span>Par {{ $information->auteur->prenom ?? 'Anonyme' }}</span>
              </div>
              <div class="article-stats">
                <span class="stat-item">👁 {{ $information->vues }}</span>
                <span class="stat-item">💬 {{ $information->commentaires->count() }}</span>
              </div>
            </div>
          </div>
        </article>
      @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
          <div class="empty-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
          </div>
          <h3 class="empty-title">Aucune information disponible</h3>
          <p>Revenez bientôt pour découvrir nos dernières nouvelles.</p>
        </div>
      @endforelse
    </div>
  </main>

  <script>
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const category = this.dataset.category;
        const articles = document.querySelectorAll('.article-card');

        articles.forEach(article => {
          if (category === 'all' || article.dataset.category === category) {
            article.style.display = '';
          } else {
            article.style.display = 'none';
          }
        });
      });
    });
  </script>
</body>
</html>
