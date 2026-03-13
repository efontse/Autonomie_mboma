<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quiz — {{ $formation->titre }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --or-clair:#E8B96A; --ivoire:#FAF6F0;
      --creme:#F2EBE0; --blanc:#FFFFFF; --vert:#2A6049; --vert-clair:#3D8A68;
      --gris:#8A8278; --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --rouge:#DC2626;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }

    .quiz-container { max-width:800px; margin:2rem auto; padding:0 1rem; }

    .quiz-header {
      background:var(--blanc);
      border-radius:16px;
      padding:2rem;
      margin-bottom:1.5rem;
      border:1px solid var(--gris-clair);
    }
    .quiz-header h1 {
      font-family:'Cormorant Garamond',serif;
      font-size:1.8rem;
      font-weight:700;
      color:var(--brun);
      margin-bottom:0.5rem;
    }
    .quiz-header p { color:var(--texte-doux); font-size:0.95rem; }
    .quiz-meta {
      display:flex;
      gap:1.5rem;
      margin-top:1rem;
      padding-top:1rem;
      border-top:1px solid var(--gris-clair);
    }
    .quiz-meta-item { display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:var(--texte-doux); }
    .quiz-meta-item svg { width:18px; height:18px; }

    .resultat {
      background:var(--blanc);
      border-radius:16px;
      padding:2rem;
      margin-bottom:1.5rem;
      border:2px solid var(--gris-clair);
      text-align:center;
    }
    .resultat.success { border-color:var(--vert); background:rgba(42,96,73,0.05); }
    .resultat.fail { border-color:var(--rouge); background:rgba(220,38,38,0.05); }
    .resultat-icon { font-size:3rem; margin-bottom:1rem; }
    .resultat h2 { font-family:'Cormorant Garamond',serif; font-size:1.8rem; margin-bottom:0.5rem; }
    .resultat.success h2 { color:var(--vert); }
    .resultat.fail h2 { color:var(--rouge); }
    .resultat .score { font-size:2.5rem; font-weight:700; color:var(--brun); margin:1rem 0; }
    .resultat .score-minimum { font-size:0.9rem; color:var(--texte-doux); }

    .question-card {
      background:var(--blanc);
      border-radius:16px;
      padding:1.5rem;
      margin-bottom:1rem;
      border:1px solid var(--gris-clair);
    }
    .question-num {
      display:inline-block;
      background:var(--brun);
      color:var(--blanc);
      width:28px;
      height:28px;
      border-radius:50%;
      text-align:center;
      line-height:28px;
      font-size:0.8rem;
      font-weight:600;
      margin-right:0.75rem;
    }
    .question-text {
      font-size:1.05rem;
      font-weight:500;
      margin-bottom:1.25rem;
      display:inline;
    }

    .reponses-list { display:flex; flex-direction:column; gap:0.75rem; }
    .reponse-item {
      display:flex;
      align-items:center;
      padding:1rem 1.25rem;
      border:2px solid var(--gris-clair);
      border-radius:10px;
      cursor:pointer;
      transition:all 0.2s;
    }
    .reponse-item:hover { border-color:var(--or); background:rgba(201,146,58,0.05); }
    .reponse-item.selected {
      border-color:var(--or);
      background:rgba(201,146,58,0.1);
    }
    .reponse-item input { display:none; }
    .reponse-radio {
      width:20px;
      height:20px;
      border:2px solid var(--gris);
      border-radius:50%;
      margin-right:1rem;
      display:flex;
      align-items:center;
      justify-content:center;
      flex-shrink:0;
    }
    .reponse-item.selected .reponse-radio {
      border-color:var(--or);
      background:var(--or);
    }
    .reponse-item.selected .reponse-radio::after {
      content:'✓';
      color:var(--blanc);
      font-size:0.7rem;
      font-weight:700;
    }
    .reponse-text { font-size:0.95rem; }

    .quiz-actions {
      display:flex;
      gap:1rem;
      margin-top:1.5rem;
    }
    .btn {
      padding:0.85rem 1.75rem;
      border-radius:10px;
      font-size:0.95rem;
      font-weight:600;
      cursor:pointer;
      border:none;
      transition:all 0.2s;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      justify-content:center;
    }
    .btn-primary {
      background:var(--brun);
      color:var(--blanc);
    }
    .btn-primary:hover { background:var(--or); }
    .btn-secondary {
      background:transparent;
      color:var(--texte-doux);
      border:2px solid var(--gris-clair);
    }
    .btn-secondary:hover { border-color:var(--brun); color:var(--brun); }

    .tentatives-precedentes {
      margin-top:2rem;
    }
    .tentatives-precedentes h3 {
      font-family:'Cormorant Garamond',serif;
      font-size:1.3rem;
      color:var(--brun);
      margin-bottom:1rem;
    }
    .tentative-item {
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:0.75rem 1rem;
      background:var(--blanc);
      border-radius:8px;
      margin-bottom:0.5rem;
      border:1px solid var(--gris-clair);
    }
    .tentative-item.reussie { border-left:3px solid var(--vert); }
    .tentative-item.echouee { border-left:3px solid var(--rouge); }
    .tentative-score { font-weight:600; }
    .tentative-status { font-size:0.8rem; }
    .tentative-status.reussie { color:var(--vert); }
    .tentative-status.echouee { color:var(--rouge); }

    @media (max-width:600px) {
      .quiz-container { padding:0 0.75rem; }
      .quiz-header, .question-card, .resultat { padding:1.25rem; }
      .quiz-meta { flex-direction:column; gap:0.75rem; }
    }
  </style>
</head>
<body>

<div class="quiz-container">

  <a href="{{ route('formation.show', $formation) }}" style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--texte-doux);text-decoration:none;margin-bottom:1rem;font-size:0.9rem">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Retour à la formation
  </a>

  <div class="quiz-header">
    <h1>{{ $quiz->titre }}</h1>
    <p>{{ $quiz->description ?? 'Testez vos connaissances acquises pendant cette formation.' }}</p>

    <div class="quiz-meta">
      <div class="quiz-meta-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        {{ $quiz->questions->count() }} questions
      </div>
      <div class="quiz-meta-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Score minimum: {{ $quiz->score_minimum }}%
      </div>
    </div>
  </div>

  @if($meilleureTentative)
    <div class="resultat {{ $aReussi ? 'success' : 'fail' }}">
      <div class="resultat-icon">{{ $aReussi ? '🎉' : '📚' }}</div>
      <h2>{{ $aReussi ? 'Quiz réussi !' : 'Quiz non réussi' }}</h2>
      <div class="score">{{ $meilleureTentative->score }}%</div>
      <p class="score-minimum">Score minimum requis: {{ $quiz->score_minimum }}%</p>
      @if($aReussi)
        <p style="color:var(--vert);margin-top:0.5rem">Félicitations ! Vous avez completed cette formation.</p>
      @else
        <p style="color:var(--texte-doux);margin-top:0.5rem">Vous pouvez réessayer pour améliorer votre score.</p>
      @endif
    </div>
  @endif

  <form id="quiz-form" method="POST" action="{{ route('formation.quiz.soumettre', $formation) }}">
    @csrf

    @foreach($quiz->questions as $index => $question)
      <div class="question-card">
        <span class="question-num">{{ $index + 1 }}</span>
        <span class="question-text">{{ $question->question }}</span>

        <div class="reponses-list">
          @foreach($question->reponses as $reponse)
            <label class="reponse-item" data-question="{{ $question->id }}">
              <input type="radio" name="reponses[{{ $question->id }}]" value="{{ $reponse->id }}" required>
              <span class="reponse-radio"></span>
              <span class="reponse-text">{{ $reponse->reponse }}</span>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach

    <div class="quiz-actions">
      <button type="submit" class="btn btn-primary" id="btn-soumettre">
        Soumettre mes réponses
      </button>
      <a href="{{ route('formation.show', $formation) }}" class="btn btn-secondary">
        Revenir à la formation
      </a>
    </div>
  </form>

  @if($tentatives->count() > 0)
    <div class="tentatives-precedentes">
      <h3>Vos tentatives précédentes</h3>
      @foreach($tentatives as $tentative)
        <div class="tentative-item {{ $tentative->reussie ? 'reussie' : 'echouee' }}">
          <div>
            <span class="tentative-score">{{ $tentative->score }}%</span>
            <span class="tentative-status {{ $tentative->reussie ? 'reussie' : 'echouee' }}">
              {{ $tentative->reussie ? 'Réussi' : 'Non réussi' }}
            </span>
          </div>
          <span style="font-size:0.8rem;color:var(--texte-doux)">
            {{ $tentative->termine_le->format('d/m/Y H:i') }}
          </span>
        </div>
      @endforeach
    </div>
  @endif

</div>

<script>
  // Gestion de la sélection des réponses
  document.querySelectorAll('.reponse-item').forEach(item => {
    item.addEventListener('click', function() {
      const questionId = this.dataset.question;
      const container = this.closest('.reponses-list');

      // Désélectionner les autres réponses de cette question
      container.querySelectorAll('.reponse-item').forEach(i => i.classList.remove('selected'));

      // Sélectionner cette réponse
      this.classList.add('selected');
      this.querySelector('input').checked = true;
    });
  });

  // Soumission du formulaire
  document.getElementById('quiz-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const btn = document.getElementById('btn-soumettre');
    btn.disabled = true;
    btn.textContent = 'Traitement en cours...';

    const formData = new FormData(this);

    try {
      const response = await fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = await response.json();

      if (data.success) {
        // Recharger la page pour afficher le résultat
        window.location.reload();
      } else {
        alert(data.message || 'Une erreur est survenue.');
        btn.disabled = false;
        btn.textContent = 'Soumettre mes réponses';
      }
    } catch (error) {
      alert('Une erreur est survenue. Veuillez réessayer.');
      btn.disabled = false;
      btn.textContent = 'Soumettre mes réponses';
    }
  });
</script>

</body>
</html>
