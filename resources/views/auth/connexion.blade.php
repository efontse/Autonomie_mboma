<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Connexion — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --terre:#8B4513; --savane:#C8860A; --ocre:#D4A853;
      --creme:#FDF6EC; --vert:#2D6A4F; --vert-clair:#52B788;
      --brun-fonce:#3B1F0A; --blanc:#FFFFFF; --gris:#6B6B6B;
      --gris-clair:#F0EAE0; --erreur:#C0392B; --succes:#27AE60;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--brun-fonce);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem;
      position: relative;
      overflow-x: hidden;
    }
    body::before {
      content:'';
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse at 15% 20%, rgba(200,134,10,0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 85% 80%, rgba(45,106,79,0.2) 0%, transparent 50%);
    }
    .motif-geo {
      position: absolute; inset: 0;
      opacity: 0.04;
      background-image:
        repeating-linear-gradient(45deg, var(--ocre) 0, var(--ocre) 1px, transparent 0, transparent 50%),
        repeating-linear-gradient(-45deg, var(--ocre) 0, var(--ocre) 1px, transparent 0, transparent 50%);
      background-size: 40px 40px;
    }
    .carte {
      position: relative;
      z-index: 2;
      display: flex;
      max-width: 900px;
      width: 100%;
      max-height: 100vh;
      overflow: hidden;
      background: var(--blanc);
      border-radius: 20px;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5);
    }
    .deco {
      width: 38%;
      background: linear-gradient(160deg, var(--vert) 0%, #1a4030 60%, #0e2a1e 100%);
      padding: 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    .deco::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(circle at 30% 30%, rgba(200,134,10,0.2) 0%, transparent 60%),
        radial-gradient(circle at 70% 70%, rgba(82,183,136,0.1) 0%, transparent 60%);
    }
    .deco-motif {
      position: absolute; inset: 0;
      opacity: 0.05;
      background-image: repeating-linear-gradient(
        45deg, var(--ocre) 0, var(--ocre) 1px, transparent 0, transparent 30px
      );
    }
    .deco-logo {
      position: relative;
      z-index: 1;
      text-align: center;
      margin-bottom: 1rem;
    }
    .logo-cercle {
      width: 60px; height: 60px;
      background: linear-gradient(135deg, var(--savane), var(--ocre));
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 0.75rem;
      font-size: 1.6rem;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    .deco h2 {
      font-family: 'Playfair Display', serif;
      color: var(--blanc);
      font-size: 1.2rem;
      line-height: 1.25;
    }
    .deco-sous {
      color: var(--vert-clair);
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      margin-top: 0.3rem;
    }
    .deco-avantages {
      position: relative;
      z-index: 1;
      list-style: none;
      width: 100%;
    }
    .deco-avantages li {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: rgba(255,255,255,0.8);
      font-size: 0.75rem;
      padding: 0.35rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .deco-avantages li:last-child { border-bottom: none; }
    .deco-avantages .ico-av { font-size: 1rem; width: 22px; text-align: center; }
    .form-zone {
      flex: 1;
      padding: 2.5rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: var(--creme);
    }
    .form-titre h1 {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem;
      color: var(--brun-fonce);
      margin-bottom: 0.3rem;
    }
    .form-titre p { color: var(--gris); font-size: 0.88rem; margin-bottom: 1.2rem; }
    .form-titre a { color: var(--vert); font-weight: 600; text-decoration: none; }
    .form-titre a:hover { text-decoration: underline; }
    .alerte {
      padding: 0.85rem 1rem;
      border-radius: 9px;
      font-size: 0.84rem;
      margin-bottom: 1.2rem;
      display: none;
    }
    .alerte.erreur { background:#fdecea; color:var(--erreur); border:1px solid #f5c6c2; display:block; }
    .alerte.succes { background:#e6f9ef; color:var(--succes); border:1px solid #b7eecf; display:block; }
    .champ { margin-bottom: 0.9rem; }
    label {
      display: block;
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--brun-fonce);
      margin-bottom: 0.4rem;
    }
    .input-wrap { position: relative; }
    .input-wrap .ico {
      position: absolute; left: 12px; top: 50%;
      transform: translateY(-50%);
      font-size: 1rem; pointer-events: none; color: var(--gris);
    }
    .input-wrap .toggle-mdp {
      position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%);
      cursor: pointer; font-size: 1rem; color: var(--gris);
      pointer-events: all;
      user-select: none;
    }
    input {
      width: 100%;
      padding: 0.75rem 2.6rem 0.75rem 2.5rem;
      border: 1.5px solid #D5C9B8;
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      color: var(--brun-fonce);
      background: var(--blanc);
      transition: border-color 0.25s, box-shadow 0.25s;
      outline: none;
    }
    input:focus {
      border-color: var(--vert);
      box-shadow: 0 0 0 3px rgba(45,106,79,0.12);
    }
    input.erreur-champ { border-color: var(--erreur); }
    .msg-erreur { font-size: 0.75rem; color: var(--erreur); display: none; margin-top: 3px; }
    .msg-erreur.visible { display: block; }
    .mdp-ligne {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.4rem;
    }
    .mdp-ligne label { margin-bottom: 0; }
    .lien-oublie { font-size: 0.8rem; color: var(--vert); text-decoration: none; font-weight: 500; }
    .lien-oublie:hover { text-decoration: underline; }
    .remember-wrap {
      display: flex; align-items: center; gap: 0.6rem;
      margin-bottom: 1.5rem;
    }
    .remember-wrap input[type="checkbox"] {
      width: 16px; height: 16px; padding: 0;
      accent-color: var(--vert);
    }
    .remember-wrap label { font-size: 0.82rem; font-weight: 400; color: var(--gris); margin: 0; }
    .btn-connexion {
      width: 100%;
      padding: 0.85rem;
      background: linear-gradient(135deg, var(--vert) 0%, #1a5c3a 100%);
      color: var(--blanc);
      border: none;
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(45,106,79,0.3);
      transition: all 0.25s;
    }
    .btn-connexion:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(45,106,79,0.4);
    }
    .btn-connexion:active { transform: translateY(0); }
    .btn-connexion:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    .separateur {
      display: flex; align-items: center; gap: 1rem;
      margin: 1.5rem 0;
      color: var(--gris); font-size: 0.78rem;
    }
    .separateur::before, .separateur::after {
      content: ''; flex: 1; height: 1px; background: #D5C9B8;
    }
    .inscription-pied { text-align: center; font-size: 0.85rem; color: var(--gris); }
    .inscription-pied a { color: var(--vert); font-weight: 700; text-decoration: none; }
    .inscription-pied a:hover { text-decoration: underline; }

    @media (max-width: 700px) {
      body { padding: 0; align-items: stretch; overflow-y: hidden; }
      .carte { flex-direction: column; border-radius: 0; height: 100vh; box-shadow: none; }
      .deco { width: 100%; padding: 1rem; flex-direction: row; flex-wrap: wrap; gap: 0.5rem; min-height: auto; }
      .deco-avantages { display: none; }
      .form-zone { padding: 1.5rem 1rem; min-height: auto; }
    }
  </style>
</head>
<body>
<div class="motif-geo"></div>

<div class="carte">

  <!-- Panneau décoratif gauche -->
  <div class="deco">
    <div class="deco-motif"></div>
    <div class="deco-logo">
      <div class="logo-cercle"><i class="bi bi-flower1"></i></div>
      <h2>Plateforme<br>Mboma</h2>
      <div class="deco-sous">Arrondissement de Mboma</div>
    </div>
    <ul class="deco-avantages">
      <li><span class="ico-av"><i class="bi bi-book"></i></span> Formations gratuites accessibles</li>
      <li><span class="ico-av"><i class="bi bi-lightbulb"></i></span> Accompagnement entrepreneurial</li>
      <li><span class="ico-av"><i class="bi bi-people"></i></span> Communauté solidaire</li>
      <li><span class="ico-av"><i class="bi bi-megaphone"></i></span> Informations locales fiables</li>
      <li><span class="ico-av"><i class="bi bi-shield-lock"></i></span> Espace sécurisé et confidentiel</li>
    </ul>
  </div>

  <!-- Formulaire de connexion -->
  <div class="form-zone">
    <div class="form-titre">
      <h1>Bon retour <i class="bi bi-emoji-smile"></i></h1>
      <p>Connectez-vous à votre espace personnel.<br>
        Pas encore de compte ? <a href="{{ route('auth.inscription') }}">S'inscrire gratuitement</a>
      </p>
    </div>

    <!-- Alerte (succès ou erreur) -->
    <div class="alerte" id="alerte"></div>

    <form id="form-connexion" novalidate>
      @csrf

      <div class="champ">
        <label for="email">Adresse e-mail</label>
        <div class="input-wrap">
          <span class="ico"><i class="bi bi-envelope"></i></span>
          <input type="email" id="email" name="email"
                 placeholder="vous@exemple.cm" autocomplete="email"/>
        </div>
        <span class="msg-erreur" id="err-email">Adresse e-mail invalide.</span>
      </div>

      <div class="champ">
        <div class="mdp-ligne">
          <label for="mot_de_passe">Mot de passe</label>
          <a href="{{ route('auth.reset.form') }}" class="lien-oublie">Mot de passe oublié ?</a>
        </div>
        <div class="input-wrap">
          <span class="ico"><i class="bi bi-lock"></i></span>
          <input type="password" id="mot_de_passe" name="mot_de_passe"
                 placeholder="Votre mot de passe" autocomplete="current-password"/>
          <span class="toggle-mdp" onclick="basculerMdp()" id="toggle-ico"><i class="bi bi-eye"></i></span>
        </div>
        <span class="msg-erreur" id="err-mdp">Mot de passe requis.</span>
      </div>

      <div class="remember-wrap">
        <input type="checkbox" id="remember" name="remember" value="1"/>
        <label for="remember">Rester connectée sur cet appareil</label>
      </div>

      <button type="submit" class="btn-connexion" id="btn-cnx">
        <i class="bi bi-box-arrow-in-right"></i> Se connecter
      </button>

    </form>

    <div class="separateur">ou</div>
    <div class="inscription-pied">
      Première visite ? <a href="{{ route('auth.inscription') }}">Créer un compte gratuit →</a>
    </div>
  </div>
</div>

<script>
  let mdpVisible = false;

  // ── Afficher / masquer le mot de passe ───────────────────
  function basculerMdp() {
    mdpVisible = !mdpVisible;
    document.getElementById('mot_de_passe').type = mdpVisible ? 'text' : 'password';
    document.getElementById('toggle-ico').innerHTML = mdpVisible ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
  }

  // ── Validation front-end ─────────────────────────────────
  function valider() {
    let ok = true;

    const emailVal = document.getElementById('email').value.trim();
    const emailOk  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal);
    document.getElementById('email').classList.toggle('erreur-champ', !emailOk);
    document.getElementById('err-email').classList.toggle('visible', !emailOk);
    if (!emailOk) ok = false;

    const mdpVal = document.getElementById('mot_de_passe').value;
    const mdpOk  = mdpVal.length >= 1;
    document.getElementById('mot_de_passe').classList.toggle('erreur-champ', !mdpOk);
    document.getElementById('err-mdp').classList.toggle('visible', !mdpOk);
    if (!mdpOk) ok = false;

    return ok;
  }

  // ── Soumission du formulaire → appel Laravel ─────────────
  document.getElementById('form-connexion').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Variables déclarées ici pour être accessibles partout dans la fonction
    const alerte = document.getElementById('alerte');
    const btn    = document.getElementById('btn-cnx');

    if (!valider()) return;

    // Désactiver le bouton pendant l'envoi
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Connexion en cours...';
    alerte.className = 'alerte';
    alerte.style.display = 'none';

    try {
      const formData = new FormData(this);

      const response = await fetch('{{ route("auth.connecter") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: formData
      });

      const data = await response.json();

      if (data.success) {
        // Connexion reussie
        alerte.className = 'alerte succes';
        alerte.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + data.message;
        alerte.style.display = 'block';
        setTimeout(() => { window.location.href = data.redirect; }, 1000);

      } else {
        // Identifiants incorrects ou compte suspendu
        alerte.className = 'alerte erreur';
        alerte.innerHTML = '<i class="bi bi-x-circle-fill"></i> ' + (data.message || 'Une erreur est survenue.');
        alerte.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-box-arrow-in-right"></i> Se connecter';
      }

    } catch (erreur) {
      // Erreur reseau ou serveur inaccessible
      alerte.className = 'alerte erreur';
      alerte.innerHTML = '<i class="bi bi-wifi-off"></i> Erreur réseau. Vérifiez votre connexion et réessayez.';
      alerte.style.display = 'block';
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-box-arrow-in-right"></i> Se connecter';
    }
  });
</script>
</body>
</html>
