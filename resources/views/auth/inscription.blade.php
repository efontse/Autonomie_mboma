<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscription — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --terre:    #8B4513;
      --savane:   #C8860A;
      --ocre:     #D4A853;
      --creme:    #FDF6EC;
      --vert:     #2D6A4F;
      --vert-clair:#52B788;
      --brun-fonce:#3B1F0A;
      --blanc:    #FFFFFF;
      --gris:     #6B6B6B;
      --gris-clair:#F0EAE0;
      --erreur:   #C0392B;
      --succes:   #27AE60;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--brun-fonce);
      min-height: 100vh;
      display: flex;
      align-items: stretch;
      overflow-x: hidden;
    }

    .panneau-gauche {
      width: 42%;
      background: linear-gradient(160deg, var(--vert) 0%, #1a4030 50%, var(--brun-fonce) 100%);
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 3rem 2.5rem;
      overflow: hidden;
    }
    .panneau-gauche::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at 20% 20%, rgba(200,134,10,0.18) 0%, transparent 55%),
        radial-gradient(circle at 80% 80%, rgba(82,183,136,0.15) 0%, transparent 50%);
    }
    .motif-geo {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      opacity: 0.06;
      background-image:
        repeating-linear-gradient(45deg, var(--ocre) 0, var(--ocre) 1px, transparent 0, transparent 50%),
        repeating-linear-gradient(-45deg, var(--ocre) 0, var(--ocre) 1px, transparent 0, transparent 50%);
      background-size: 30px 30px;
    }
    .logo-zone {
      position: relative;
      z-index: 2;
      text-align: center;
      margin-bottom: 3rem;
    }
    .logo-embleme {
      width: 90px; height: 90px;
      background: linear-gradient(135deg, var(--savane), var(--ocre));
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.2rem;
      box-shadow: 0 8px 30px rgba(0,0,0,0.35);
      font-size: 2.6rem;
    }
    .logo-nom {
      font-family: 'Playfair Display', serif;
      color: var(--blanc);
      font-size: 1.6rem;
      line-height: 1.2;
      margin-bottom: 0.4rem;
    }
    .logo-sous {
      color: var(--vert-clair);
      font-size: 0.82rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }
    .citation-bloc {
      position: relative;
      z-index: 2;
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.12);
      border-left: 4px solid var(--ocre);
      border-radius: 12px;
      padding: 1.8rem;
      color: rgba(255,255,255,0.88);
      font-size: 0.95rem;
      line-height: 1.65;
      font-style: italic;
      margin-bottom: 2.5rem;
    }
    .citation-auteur {
      margin-top: 1rem;
      font-style: normal;
      font-weight: 600;
      color: var(--ocre);
      font-size: 0.82rem;
    }
    .stats-row {
      position: relative;
      z-index: 2;
      display: flex;
      gap: 1.5rem;
    }
    .stat-item { text-align: center; }
    .stat-nombre {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      color: var(--ocre);
      display: block;
    }
    .stat-label {
      font-size: 0.72rem;
      color: rgba(255,255,255,0.6);
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .panneau-droit {
      flex: 1;
      background: var(--creme);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 2rem;
      overflow-y: auto;
    }
    .carte-form {
      width: 100%;
      max-width: 520px;
    }
    .form-entete { margin-bottom: 2.2rem; }
    .form-entete h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      color: var(--brun-fonce);
      margin-bottom: 0.4rem;
    }
    .form-entete p { color: var(--gris); font-size: 0.9rem; }
    .form-entete a { color: var(--vert); font-weight: 600; text-decoration: none; }
    .form-entete a:hover { text-decoration: underline; }

    .etapes {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
      gap: 0;
    }
    .etape {
      display: flex;
      flex-direction: column;
      align-items: center;
      flex: 1;
      position: relative;
    }
    .etape:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 16px;
      left: 50%;
      width: 100%;
      height: 2px;
      background: var(--gris-clair);
      z-index: 0;
      transition: background 0.4s;
    }
    .etape.active:not(:last-child)::after,
    .etape.done:not(:last-child)::after { background: var(--vert-clair); }
    .etape-cercle {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--gris-clair);
      border: 2px solid var(--gris-clair);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--gris);
      z-index: 1;
      transition: all 0.3s;
    }
    .etape.active .etape-cercle {
      background: var(--vert);
      border-color: var(--vert);
      color: var(--blanc);
      box-shadow: 0 0 0 4px rgba(45,106,79,0.15);
    }
    .etape.done .etape-cercle {
      background: var(--vert-clair);
      border-color: var(--vert-clair);
      color: var(--blanc);
    }
    .etape-label {
      margin-top: 6px;
      font-size: 0.68rem;
      color: var(--gris);
      font-weight: 500;
      text-align: center;
    }
    .etape.active .etape-label { color: var(--vert); font-weight: 600; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-grid.full { grid-template-columns: 1fr; }
    .champ { display: flex; flex-direction: column; gap: 0.4rem; }
    .champ.span2 { grid-column: span 2; }
    label {
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--brun-fonce);
      letter-spacing: 0.02em;
    }
    .requis { color: var(--savane); }
    .input-wrap { position: relative; }
    .input-wrap .ico {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      width: 18px; height: 18px;
      pointer-events: none;
      color: var(--gris);
    }
    .input-wrap .ico svg {
      width: 100%; height: 100%;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="date"],
    select {
      width: 100%;
      padding: 0.72rem 0.9rem 0.72rem 2.4rem;
      border: 1.5px solid #D5C9B8;
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      color: var(--brun-fonce);
      background: var(--blanc);
      transition: border-color 0.25s, box-shadow 0.25s;
      outline: none;
      -webkit-appearance: none;
    }
    input:focus, select:focus {
      border-color: var(--vert);
      box-shadow: 0 0 0 3px rgba(45,106,79,0.12);
    }
    input.erreur-champ { border-color: var(--erreur); }
    .msg-erreur { font-size: 0.75rem; color: var(--erreur); display: none; }
    .msg-erreur.visible { display: block; }

    .force-mdp { margin-top: 0.4rem; display: flex; gap: 4px; }
    .force-barre {
      flex: 1; height: 4px;
      border-radius: 4px;
      background: var(--gris-clair);
      transition: background 0.3s;
    }
    .force-label { font-size: 0.72rem; color: var(--gris); margin-top: 2px; }

    .cgu-wrap {
      display: flex;
      align-items: flex-start;
      gap: 0.7rem;
      margin-top: 0.5rem;
    }
    .cgu-wrap input[type="checkbox"] {
      width: 18px; height: 18px;
      padding: 0;
      margin-top: 2px;
      accent-color: var(--vert);
      flex-shrink: 0;
    }
    .cgu-wrap label { font-size: 0.82rem; font-weight: 400; color: var(--gris); cursor: pointer; }
    .cgu-wrap a { color: var(--vert); font-weight: 600; }

    .nav-btns {
      display: flex;
      justify-content: space-between;
      margin-top: 1.8rem;
      gap: 1rem;
    }
    .btn {
      padding: 0.78rem 1.8rem;
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s;
      border: none;
    }
    .btn-retour {
      background: transparent;
      border: 1.5px solid #C8BBAA;
      color: var(--gris);
    }
    .btn-retour:hover { background: var(--gris-clair); }
    .btn-suivant, .btn-inscrire {
      background: linear-gradient(135deg, var(--vert) 0%, #1a5c3a 100%);
      color: var(--blanc);
      flex: 1;
      max-width: 220px;
      box-shadow: 0 4px 15px rgba(45,106,79,0.3);
    }
    .btn-suivant:hover, .btn-inscrire:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(45,106,79,0.4);
    }
    .btn-inscrire { max-width: 100%; width: 100%; margin-top: 1.2rem; }
    .btn-inscrire:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    .separateur {
      display: flex; align-items: center; gap: 1rem;
      margin: 1.4rem 0;
      color: var(--gris);
      font-size: 0.78rem;
    }
    .separateur::before, .separateur::after {
      content: ''; flex: 1;
      height: 1px; background: #D5C9B8;
    }

    .roles-grille {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0.8rem;
      margin-top: 0.5rem;
    }
    .role-carte {
      border: 2px solid #D5C9B8;
      border-radius: 10px;
      padding: 0.9rem;
      cursor: pointer;
      transition: all 0.25s;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      background: var(--blanc);
    }
    .role-carte:hover { border-color: var(--vert-clair); background: #f0f9f4; }
    .role-carte.selectionne { border-color: var(--vert); background: #e8f5ef; }
    .role-emoji { width: 32px; height: 32px; flex-shrink: 0; }
    .role-emoji svg { width: 100%; height: 100%; }
    .role-info { min-width: 0; }
    .role-titre { font-size: 0.82rem; font-weight: 700; color: var(--brun-fonce); }
    .role-desc  { font-size: 0.72rem; color: var(--gris); margin-top: 2px; }

    .etape-section { display: none; }
    .etape-section.visible { display: block; }

    .alerte {
      padding: 0.9rem 1.1rem;
      border-radius: 9px;
      font-size: 0.84rem;
      margin-bottom: 1.2rem;
      display: none;
    }
    .alerte.erreur { background: #fdecea; color: var(--erreur); border: 1px solid #f5c6c2; display: block; }
    .alerte.succes { background: #e6f9ef; color: var(--succes); border: 1px solid #b7eecf; display: block; }

    @media (max-width: 768px) {
      body { flex-direction: column; }
      .panneau-gauche { width: 100%; min-height: 220px; padding: 2rem; }
      .stats-row { gap: 2rem; }
      .panneau-droit { padding: 2rem 1.2rem; }
      .form-grid { grid-template-columns: 1fr; }
      .champ.span2 { grid-column: span 1; }
      .citation-bloc { display: none; }
      .roles-grille { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- PANNEAU GAUCHE -->
<div class="panneau-gauche">
  <div class="motif-geo"></div>
  <div class="logo-zone">
    <div class="logo-embleme">🌸</div>
    <div class="logo-nom">Plateforme Mboma</div>
    <div class="logo-sous">Autonomisation • Femme • Jeune Fille</div>
  </div>
  <div class="citation-bloc">
    « L'éducation d'une femme, c'est l'éducation d'une nation entière. »
    <div class="citation-auteur">— Proverbe africain</div>
  </div>
  <div class="stats-row">
    <div class="stat-item">
      <span class="stat-nombre">500+</span>
      <span class="stat-label">Membres</span>
    </div>
    <div class="stat-item">
      <span class="stat-nombre">30+</span>
      <span class="stat-label">Formations</span>
    </div>
    <div class="stat-item">
      <span class="stat-nombre">12</span>
      <span class="stat-label">Villages</span>
    </div>
  </div>
</div>

<!-- PANNEAU DROIT -->
<div class="panneau-droit">
  <div class="carte-form">

    <div class="form-entete">
      <h1>Créer un compte</h1>
      <p>Déjà inscrite ? <a href="{{ route('auth.connexion') }}">Se connecter</a></p>
    </div>

    <!-- Indicateur d'étapes -->
    <div class="etapes" id="indicateur-etapes">
      <div class="etape active" id="ind-1">
        <div class="etape-cercle">1</div>
        <div class="etape-label">Identité</div>
      </div>
      <div class="etape" id="ind-2">
        <div class="etape-cercle">2</div>
        <div class="etape-label">Compte</div>
      </div>
      <div class="etape" id="ind-3">
        <div class="etape-cercle">3</div>
        <div class="etape-label">Profil</div>
      </div>
    </div>

    <!-- Alerte générale -->
    <div class="alerte" id="alerte-globale"></div>

    <form id="form-inscription" novalidate>
      @csrf

      <!-- ÉTAPE 1 : Identité -->
      <div class="etape-section visible" id="section-1">
        <div class="form-grid">

          <div class="champ">
            <label for="prenom">Prénom <span class="requis">*</span></label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
              <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" autocomplete="given-name"/>
            </div>
            <span class="msg-erreur" id="err-prenom">Prénom requis.</span>
          </div>

          <div class="champ">
            <label for="nom">Nom <span class="requis">*</span></label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
              <input type="text" id="nom" name="nom" placeholder="Votre nom" autocomplete="family-name"/>
            </div>
            <span class="msg-erreur" id="err-nom">Nom requis.</span>
          </div>

          <div class="champ">
            <label for="date_naissance">Date de naissance</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
              <input type="date" id="date_naissance" name="date_naissance"/>
            </div>
          </div>

          <div class="champ">
            <label for="telephone">Téléphone</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
              <input type="tel" id="telephone" name="telephone" placeholder="+237 6XX XXX XXX"/>
            </div>
          </div>

          <div class="champ span2">
            <label>Votre profil <span class="requis">*</span></label>
            <div class="roles-grille">
              <div class="role-carte selectionne" data-role="femme" onclick="selectionnerRole(this)">
                <span class="role-emoji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></span>
                <div class="role-info">
                  <div class="role-titre">Femme adulte</div>
                  <div class="role-desc">Accès à toutes les ressources</div>
                </div>
              </div>
              <div class="role-carte" data-role="jeune_fille" onclick="selectionnerRole(this)">
                <span class="role-emoji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg></span>
                <div class="role-info">
                  <div class="role-titre">Jeune fille</div>
                  <div class="role-desc">Contenu adapté 13-25 ans</div>
                </div>
              </div>
              <div class="role-carte" data-role="entrepreneur" onclick="selectionnerRole(this)">
                <span class="role-emoji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></span>
                <div class="role-info">
                  <div class="role-titre">Entrepreneuse</div>
                  <div class="role-desc">Module entrepreneurial avancé</div>
                </div>
              </div>
              <div class="role-carte" data-role="autre" onclick="selectionnerRole(this)">
                <span class="role-emoji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                <div class="role-info">
                  <div class="role-titre">Partenaire</div>
                  <div class="role-desc">ONG, association, institution</div>
                </div>
              </div>
            </div>
            <input type="hidden" id="role" name="role" value="femme"/>
            <span class="msg-erreur" id="err-role"></span>
          </div>

        </div>
        <div class="nav-btns">
          <div></div>
          <button type="button" class="btn btn-suivant" onclick="allerEtape(2)">Continuer →</button>
        </div>
      </div>

      <!-- ÉTAPE 2 : Informations de compte -->
      <div class="etape-section" id="section-2">
        <div class="form-grid full">

          <div class="champ">
            <label for="email">Adresse e-mail <span class="requis">*</span></label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
              <input type="email" id="email" name="email" placeholder="vous@exemple.cm" autocomplete="email"/>
            </div>
            <span class="msg-erreur" id="err-email">E-mail invalide.</span>
          </div>

          <div class="champ">
            <label for="mot_de_passe">Mot de passe <span class="requis">*</span></label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
              <input type="password" id="mot_de_passe" name="mot_de_passe"
                     placeholder="8 caractères minimum"
                     oninput="evaluerForce(this.value)"/>
            </div>
            <div class="force-mdp">
              <div class="force-barre" id="f1"></div>
              <div class="force-barre" id="f2"></div>
              <div class="force-barre" id="f3"></div>
              <div class="force-barre" id="f4"></div>
            </div>
            <span class="force-label" id="force-txt"></span>
            <span class="msg-erreur" id="err-mdp">8 caractères minimum requis.</span>
          </div>

          <div class="champ">
            <label for="mot_de_passe_confirmation">Confirmer le mot de passe <span class="requis">*</span></label>
            <div class="input-wrap">
              <span class="ico">🔒</span>
              {{-- Nom = mot_de_passe_confirmation pour que Laravel valide automatiquement --}}
              <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" placeholder="Répétez le mot de passe"/>
            </div>
            <span class="msg-erreur" id="err-confirm">Les mots de passe ne correspondent pas.</span>
          </div>

          <div class="champ">
            <div class="cgu-wrap">
              <input type="checkbox" id="cgu" name="cgu" value="1"/>
              <label for="cgu">
                J'accepte les <a href="#">Conditions d'utilisation</a> et la
                <a href="#">Politique de confidentialité</a> de la plateforme Mboma.
              </label>
            </div>
            <span class="msg-erreur" id="err-cgu">Veuillez accepter les conditions.</span>
          </div>

        </div>
        <div class="nav-btns">
          <button type="button" class="btn btn-retour" onclick="allerEtape(1)">← Retour</button>
          <button type="button" class="btn btn-suivant" onclick="allerEtape(3)">Continuer →</button>
        </div>
      </div>

      <!-- ÉTAPE 3 : Localisation & Profil -->
      <div class="etape-section" id="section-3">
        <div class="form-grid">

          <div class="champ">
            <label for="quartier">Quartier / Rue</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
              <input type="text" id="quartier" name="quartier" placeholder="Votre quartier"/>
            </div>
          </div>

          <div class="champ">
            <label for="village">Village</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
              <input type="text" id="village" name="village" placeholder="Votre village"/>
            </div>
          </div>

          <div class="champ span2">
            <label for="niveau_education">Niveau d'éducation</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span>
              <select id="niveau_education" name="niveau_education">
                <option value="">— Sélectionner —</option>
                <option value="aucun">Aucun</option>
                <option value="primaire">Primaire</option>
                <option value="secondaire">Secondaire</option>
                <option value="universitaire">Universitaire</option>
                <option value="formation_pro">Formation professionnelle</option>
              </select>
            </div>
          </div>

          <div class="champ span2">
            <label for="activite_principale">Activité principale</label>
            <div class="input-wrap">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></span>
              <input type="text" id="activite_principale" name="activite_principale"
                     placeholder="Agriculture, couture, commerce…"/>
            </div>
          </div>

        </div>

        <div class="separateur">Récapitulatif</div>
        <div id="recap" style="background:var(--gris-clair);border-radius:9px;padding:1rem;font-size:0.85rem;color:var(--brun-fonce);line-height:1.7;"></div>

        <div class="nav-btns" style="flex-direction:column;align-items:stretch;">
          <button type="button" class="btn btn-retour" style="width:100%;text-align:center;" onclick="allerEtape(2)">← Retour</button>
          <button type="submit" class="btn btn-inscrire" id="btn-inscrire">✅ Créer mon compte</button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  let etapeActuelle = 1;
  const totalEtapes = 3;

  // ── Navigation entre étapes ──────────────────────────────
  function allerEtape(n) {
    if (n > etapeActuelle && !validerEtape(etapeActuelle)) return;
    afficherSection(n);
    if (n === 3) genererRecap();
  }

  function afficherSection(n) {
    document.querySelectorAll('.etape-section').forEach(s => s.classList.remove('visible'));
    document.getElementById('section-' + n).classList.add('visible');
    for (let i = 1; i <= totalEtapes; i++) {
      const ind = document.getElementById('ind-' + i);
      ind.classList.remove('active', 'done');
      if (i < n) ind.classList.add('done');
      if (i === n) ind.classList.add('active');
      ind.querySelector('.etape-cercle').innerHTML = i < n ? '✓' : i;
    }
    etapeActuelle = n;
  }

  function selectionnerRole(carte) {
    document.querySelectorAll('.role-carte').forEach(c => c.classList.remove('selectionne'));
    carte.classList.add('selectionne');
    document.getElementById('role').value = carte.dataset.role;
  }

  // ── Validation par étape ─────────────────────────────────
  function validerEtape(e) {
    let ok = true;
    if (e === 1) {
      ok = requis('prenom', 'err-prenom', 'Prénom requis.') & ok;
      ok = requis('nom', 'err-nom', 'Nom requis.') & ok;
    }
    if (e === 2) {
      ok = validerEmail('email', 'err-email') & ok;
      ok = validerMdp('mot_de_passe', 'err-mdp') & ok;
      ok = validerConfirm('mot_de_passe', 'mot_de_passe_confirmation', 'err-confirm') & ok;
      ok = validerCgu('cgu', 'err-cgu') & ok;
    }
    return ok;
  }

  function requis(id, errId, msg) {
    const v = document.getElementById(id).value.trim();
    const ok = v.length > 0;
    afficherErreur(id, errId, !ok, msg);
    return ok;
  }
  function validerEmail(id, errId) {
    const v = document.getElementById(id).value.trim();
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    afficherErreur(id, errId, !ok, 'Adresse e-mail invalide.');
    return ok;
  }
  function validerMdp(id, errId) {
    const v = document.getElementById(id).value;
    const ok = v.length >= 8;
    afficherErreur(id, errId, !ok, '8 caractères minimum requis.');
    return ok;
  }
  function validerConfirm(id1, id2, errId) {
    const ok = document.getElementById(id1).value === document.getElementById(id2).value;
    afficherErreur(id2, errId, !ok, 'Les mots de passe ne correspondent pas.');
    return ok;
  }
  function validerCgu(id, errId) {
    const ok = document.getElementById(id).checked;
    document.getElementById(errId).classList.toggle('visible', !ok);
    return ok;
  }
  function afficherErreur(inputId, errId, condition, msg) {
    document.getElementById(inputId).classList.toggle('erreur-champ', condition);
    const err = document.getElementById(errId);
    err.textContent = msg;
    err.classList.toggle('visible', condition);
  }

  // ── Indicateur de force du mot de passe ─────────────────
  function evaluerForce(v) {
    const criteres = [v.length >= 8, /[A-Z]/.test(v), /[0-9]/.test(v), /[^A-Za-z0-9]/.test(v)];
    const score = criteres.filter(Boolean).length;
    const couleurs = ['', '#e74c3c', '#e67e22', '#f1c40f', '#27ae60'];
    const etiquettes = ['', 'Très faible', 'Faible', 'Moyen', 'Fort'];
    for (let i = 1; i <= 4; i++) {
      document.getElementById('f' + i).style.background = i <= score ? couleurs[score] : '#e0d6c8';
    }
    document.getElementById('force-txt').textContent = score ? etiquettes[score] : '';
    document.getElementById('force-txt').style.color = couleurs[score] || '';
  }

  // ── Récapitulatif étape 3 ────────────────────────────────
  function genererRecap() {
    const val = id => document.getElementById(id).value.trim();
    const role = document.querySelector('.role-carte.selectionne')?.querySelector('.role-titre')?.textContent || '—';
    const niveauSelect = document.getElementById('niveau_education');
    const niveau = niveauSelect.options[niveauSelect.selectedIndex].text;
    document.getElementById('recap').innerHTML = `
      <b>Nom :</b> ${val('prenom')} ${val('nom')}<br>
      <b>E-mail :</b> ${val('email')}<br>
      <b>Profil :</b> ${role}<br>
      <b>Village :</b> ${val('village') || '—'}<br>
      <b>Niveau :</b> ${niveau}
    `;
  }

  // ── Soumission du formulaire → appel Laravel ─────────────
  document.getElementById('form-inscription').addEventListener('submit', async function(e) {
    e.preventDefault(); // Empêche le rechargement de page

    const alerte = document.getElementById('alerte-globale');
    const btn    = document.getElementById('btn-inscrire');

    // Désactiver le bouton pendant l'envoi
    btn.disabled = true;
    btn.textContent = '⏳ Enregistrement…';
    alerte.className = 'alerte';
    alerte.style.display = 'none';

    try {
      const formData = new FormData(this);

      const response = await fetch('{{ route("auth.inscrire") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: formData
      });

      const data = await response.json();

      if (data.success) {
        // ✅ Succès : afficher le message puis rediriger
        alerte.className = 'alerte succes';
        alerte.textContent = '✅ ' + data.message;
        alerte.scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => { window.location.href = data.redirect; }, 1500);

      } else {
        // ❌ Erreurs de validation Laravel
        alerte.className = 'alerte erreur';
        if (data.errors) {
          const msgs = Object.values(data.errors).flat().join(' • ');
          alerte.textContent = '❌ ' + msgs;
        } else {
          alerte.textContent = '❌ ' + (data.message || 'Une erreur est survenue.');
        }
        alerte.scrollIntoView({ behavior: 'smooth' });
        btn.disabled = false;
        btn.textContent = '✅ Créer mon compte';
      }

    } catch (erreur) {
      // ❌ Erreur réseau ou serveur
      alerte.className = 'alerte erreur';
      alerte.textContent = '❌ Erreur réseau. Vérifiez votre connexion et réessayez.';
      alerte.scrollIntoView({ behavior: 'smooth' });
      btn.disabled = false;
      btn.textContent = '✅ Créer mon compte';
    }
  });
</script>
</body>
</html>
