<?php
// ============================================================
// resources/views/Information_show.blade.php
// Page d'affichage d'une information détaillée
// ============================================================

use App\Models\Information;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $information->titre }} - Mboma Platform</title>
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
      max-width: 800px;
      margin: 0 auto;
      padding: 2rem;
    }

    /* Back link */
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--vert);
      text-decoration: none;
      font-weight: 500;
      margin-bottom: 1.5rem;
      transition: color 0.2s;
    }

    .back-link:hover {
      color: var(--vert-clair);
    }

    /* Article */
    .article {
      background: var(--blanc);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .article-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .article-image-placeholder {
      width: 100%;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--vert-clair) 0%, var(--vert) 100%);
      color: var(--blanc);
      font-size: 6rem;
    }

    .article-body {
      padding: 2rem;
    }

    .article-category {
      display: inline-block;
      padding: 0.35rem 1rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--blanc);
      margin-bottom: 1rem;
    }

    .article-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      color: #333;
      margin-bottom: 1rem;
      line-height: 1.3;
    }

    .article-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--gris-clair);
      margin-bottom: 1.5rem;
      color: var(--gris);
      font-size: 0.9rem;
    }

    .article-author {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .article-stats {
      display: flex;
      gap: 1.5rem;
    }

    .stat-item {
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    .article-content {
      color: #444;
      line-height: 1.8;
      font-size: 1.05rem;
    }

    .article-content p {
      margin-bottom: 1.25rem;
    }

    /* Comments section */
    .comments-section {
      margin-top: 2.5rem;
      padding-top: 2rem;
      border-top: 1px solid var(--gris-clair);
    }

    .comments-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      color: var(--terre);
      margin-bottom: 1.5rem;
    }

    .comment {
      padding: 1.25rem;
      background: var(--gris-clair);
      border-radius: 12px;
      margin-bottom: 1rem;
    }

    .comment-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
    }

    .comment-author {
      font-weight: 600;
      color: #333;
    }

    .comment-date {
      font-size: 0.8rem;
      color: var(--gris);
    }

    .comment-content {
      color: #555;
      line-height: 1.6;
    }

    .no-comments {
      text-align: center;
      padding: 2rem;
      color: var(--gris);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .container {
        padding: 1rem;
      }

      .article-body {
        padding: 1.5rem;
      }

      .article-title {
        font-size: 1.5rem;
      }

      .article-image,
      .article-image-placeholder {
        height: 250px;
      }

      .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
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
      <a href="{{ route('informations.index') }}" class="header-link">Informations</a>
      <a href="#" class="header-link">Formations</a>
      <div class="header-user">
        <span>{{ Auth::user()->prenom ?? 'Utilisateur' }}</span>
      </div>
    </nav>
  </header>

  <!-- Main content -->
  <main class="container">
    <a href="{{ route('informations.index') }}" class="back-link">
      ← Retour aux informations
    </a>

    <article class="article">
      @if($information->image_url)
        <img src="{{ $information->image_url }}" alt="{{ $information->titre }}" class="article-image">
      @else
        <div class="article-image-placeholder">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
          </svg>
        </div>
      @endif

      <div class="article-body">
        <?php $categorieCouleur = $information->categorieCouleur(); ?>
        <span class="article-category" style="background-color: <?php echo $categorieCouleur; ?>">
          {{ $information->categorieLabel() }}
        </span>

        <h1 class="article-title">{{ $information->titre }}</h1>

        <div class="article-meta">
          <div class="article-author">
            <span>Par {{ $information->auteur->prenom ?? 'Anonyme' }}</span>
            <span>•</span>
            <span>{{ $information->created_at->format('d/m/Y') }}</span>
          </div>
          <div class="article-stats">
            <span class="stat-item">👁 {{ $information->vues }} vues</span>
            <span class="stat-item">💬 {{ $information->commentaires->count() }} commentaires</span>
          </div>
        </div>

        <div class="article-content">
          {!! nl2br(e($information->contenu)) !!}
        </div>
      </div>
    </article>

    <!-- Comments section -->
    <section class="comments-section">
      <h2 class="comments-title">Commentaires ({{ $information->commentairesApprouves->count() }})</h2>

      @forelse($information->commentairesApprouves as $commentaire)
        <div class="comment">
          <div class="comment-header">
            <span class="comment-author">{{ $commentaire->auteur->prenom ?? 'Anonyme' }}</span>
            <span class="comment-date">{{ $commentaire->created_at->format('d/m/Y à H:i') }}</span>
          </div>
          <p class="comment-content">{{ $commentaire->contenu }}</p>
        </div>
      @empty
        <div class="no-comments">
          <p>Aucun commentaire pour le moment. Soyez le premier à réagir !</p>
        </div>
      @endforelse
    </section>
  </main>
</body>
</html>
