<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ isset($information) ? 'Modifier' : 'Créer' }} un article — Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --ivoire:#FAF6F0; --creme:#F2EBE0;
      --blanc:#FFFFFF; --vert:#2A6049; --gris:#8A8278;
      --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --erreur:#C0392B; --sidebar-w:260px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Outfit', sans-serif; background: var(--ivoire); color: var(--texte); }
    .page-wrap { margin-left: var(--sidebar-w); padding: 2rem; min-height: 100vh; }

    .retour {
      display: inline-flex; align-items: center; gap: 0.5rem;
      color: var(--texte-doux); text-decoration: none;
      font-size: 0.82rem; font-weight: 500; margin-bottom: 1.5rem;
      transition: color 0.2s;
    }
    .retour:hover { color: var(--or); }
    .retour svg { width: 16px; height: 16px; }

    .page-titre {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.8rem; font-weight: 700; margin-bottom: 2rem;
    }

    .form-card {
      background: var(--blanc); border-radius: 16px;
      border: 1px solid var(--gris-clair);
      padding: 2.5rem; max-width: 800px;
    }

    .champ { margin-bottom: 1.5rem; }
    .champ label {
      display: block; font-size: 0.82rem; font-weight: 600;
      color: var(--texte); margin-bottom: 0.4rem;
    }
    .requis { color: var(--or); }
    .aide { font-size: 0.73rem; color: var(--gris); margin-top: 0.3rem; }

    input[type="text"], select, textarea {
      width: 100%; padding: 0.75rem 1rem;
      border: 1.5px solid var(--gris-clair); border-radius: 9px;
      font-family: 'Outfit', sans-serif; font-size: 0.9rem;
      color: var(--texte); background: var(--blanc);
      outline: none; transition: border-color 0.2s;
      -webkit-appearance: none;
    }
    input:focus, select:focus, textarea:focus { border-color: var(--or); }
    textarea { resize: vertical; min-height: 250px; line-height: 1.7; }

    /* Upload image */
    .upload-zone {
      border: 2px dashed var(--gris-clair); border-radius: 10px;
      padding: 2rem; text-align: center; cursor: pointer;
      transition: all 0.2s; position: relative;
    }
    .upload-zone:hover { border-color: var(--or); background: rgba(201,146,58,0.03); }
    .upload-zone input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer;
      width: 100%; height: 100%; border: none; padding: 0;
    }
    .upload-ico { width: 36px; height: 36px; margin: 0 auto 0.7rem; color: var(--gris); }
    .upload-txt { font-size: 0.82rem; color: var(--texte-doux); }
    .upload-sous { font-size: 0.72rem; color: var(--gris); margin-top: 0.3rem; }
    .preview-img {
      max-width: 100%; max-height: 200px; border-radius: 8px;
      margin-top: 1rem; display: none;
    }

    /* Statut toggle */
    .statut-wrap { display: flex; gap: 1rem; }
    .statut-option {
      flex: 1; border: 2px solid var(--gris-clair); border-radius: 10px;
      padding: 0.9rem 1rem; cursor: pointer; transition: all 0.2s;
      display: flex; align-items: center; gap: 0.7rem;
    }
    .statut-option input { display: none; }
    .statut-option.selectionne { border-color: var(--vert); background: rgba(42,96,73,0.05); }
    .statut-dot {
      width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    }
    .statut-dot.publie { background: #27AE60; }
    .statut-dot.brouillon { background: var(--gris); }
    .statut-info { min-width: 0; }
    .statut-label { font-size: 0.85rem; font-weight: 600; color: var(--texte); }
    .statut-desc { font-size: 0.72rem; color: var(--texte-doux); }

    /* Actions */
    .form-actions {
      display: flex; gap: 1rem; margin-top: 2rem;
      padding-top: 1.5rem; border-top: 1px solid var(--gris-clair);
    }
    .btn-submit {
      padding: 0.78rem 2rem; background: var(--brun); color: var(--blanc);
      border: none; border-radius: 9px; font-family: 'Outfit', sans-serif;
      font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-submit:hover { background: var(--or); }
    .btn-annuler {
      padding: 0.78rem 1.5rem; background: transparent;
      border: 1.5px solid var(--gris-clair); color: var(--texte-doux);
      border-radius: 9px; font-family: 'Outfit', sans-serif;
      font-size: 0.9rem; font-weight: 500; cursor: pointer;
      text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center;
    }
    .btn-annuler:hover { background: var(--creme); }

    .msg-erreur { font-size: 0.75rem; color: var(--erreur); margin-top: 0.3rem; }
    .alerte-erreur {
      background: #fdecea; color: var(--erreur);
      border: 1px solid #f5c6c2; border-radius: 9px;
      padding: 0.9rem 1.2rem; margin-bottom: 1.5rem; font-size: 0.84rem;
    }

    /* Sidebar Complet */
    .sidebar { width:280px; background:var(--blanc); border-right:1px solid var(--gris-clair); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar-logo { padding:1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .logo-mark { width:40px; height:40px; background:#F0D9B5; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .logo-text { display:flex; flex-direction:column; }
    .logo-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--brun); }
    .logo-sub { font-size:0.7rem; color:var(--gris); text-transform:uppercase; }
    .sidebar-profil { padding:1.25rem 1.5rem; display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--gris-clair); }
    .avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--vert),#3D8A68); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:var(--blanc); position:relative; }
    .avatar-status { position:absolute; bottom:0; right:0; width:12px; height:12px; background:#3D8A68; border-radius:50%; border:2px solid var(--blanc); }
    .profil-info { flex:1; min-width:0; }
    .profil-nom { font-weight:600; font-size:0.9rem; color:var(--texte); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
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
    .btn-deconnexion svg { width:16px; height:16px; }

    @media (max-width: 768px) {
      .page-wrap { margin-left: 0; padding: 1.2rem; }
      .form-card { padding: 1.5rem; }
      .statut-wrap { flex-direction: column; }
    }
  </style>
</head>
<body>

@include('partials.sidebar')

<div class="page-wrap">

  <a href="{{ route('information.admin.index') }}" class="retour">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Retour à la gestion
  </a>

  <h1 class="page-titre">
    {{ isset($information) ? 'Modifier l\'article' : 'Publier un nouvel article' }}
  </h1>

  @if($errors->any())
    <div class="alerte-erreur">
      ❌ Veuillez corriger les erreurs ci-dessous.
    </div>
  @endif

  <div class="form-card">
    <form method="POST"
          action="{{ isset($information) ? route('information.admin.update', $information) : route('information.admin.store') }}"
          enctype="multipart/form-data">
      @csrf
      @if(isset($information)) @method('PUT') @endif

      <!-- Titre -->
      <div class="champ">
        <label for="titre">Titre de l'article <span class="requis">*</span></label>
        <input type="text" id="titre" name="titre"
               value="{{ old('titre', $information->titre ?? '') }}"
               placeholder="Ex : Campagne de vaccination à Mboma — Tout ce qu'il faut savoir"
               required maxlength="255"/>
        @error('titre') <div class="msg-erreur">{{ $message }}</div> @enderror
      </div>

      <!-- Catégorie -->
      <div class="champ">
        <label for="categorie">Catégorie <span class="requis">*</span></label>
        <select id="categorie" name="categorie" required>
          <option value="">— Choisir une catégorie —</option>
          @foreach($categories as $cle => $cat)
            <option value="{{ $cle }}"
              {{ old('categorie', $information->categorie ?? '') === $cle ? 'selected' : '' }}>
              {{ $cat['label'] }}
            </option>
          @endforeach
        </select>
        @error('categorie') <div class="msg-erreur">{{ $message }}</div> @enderror
      </div>

      <!-- Contenu -->
      <div class="champ">
        <label for="contenu">Contenu <span class="requis">*</span></label>
        <textarea id="contenu" name="contenu" required minlength="10"
                  placeholder="Rédigez le contenu de l'article…">{{ old('contenu', $information->contenu ?? '') }}</textarea>
        <div class="aide">Utilisez des sauts de ligne pour structurer votre texte.</div>
        @error('contenu') <div class="msg-erreur">{{ $message }}</div> @enderror
      </div>

      <!-- Image -->
      <div class="champ">
        <label>Image d'illustration</label>
        <div class="upload-zone" id="upload-zone">
          <input type="file" name="image" accept="image/*" onchange="previewImage(event)"/>
          <svg class="upload-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21 15 16 10 5 21"/>
          </svg>
          <div class="upload-txt">Cliquez ou glissez une image ici</div>
          <div class="upload-sous">JPEG, PNG, WebP — max 2 Mo</div>
          <img id="preview" class="preview-img" alt="Aperçu"/>
        </div>
        @if(isset($information) && $information->image_url)
          <div style="margin-top:0.7rem;font-size:0.78rem;color:var(--texte-doux)">
            Image actuelle :
            <img src="{{ asset('storage/'.$information->image_url) }}"
                 style="max-width:120px;border-radius:6px;margin-left:0.5rem;vertical-align:middle"/>
          </div>
        @endif
        @error('image') <div class="msg-erreur">{{ $message }}</div> @enderror
      </div>

      <!-- Statut -->
      <div class="champ">
        <label>Statut de publication <span class="requis">*</span></label>
        <div class="statut-wrap">
          <label class="statut-option {{ old('statut', $information->statut ?? 'brouillon') === 'publie' ? 'selectionne' : '' }}"
                 id="opt-publie" onclick="selectionnerStatut('publie')">
            <input type="radio" name="statut" value="publie"
                   {{ old('statut', $information->statut ?? '') === 'publie' ? 'checked' : '' }}/>
            <div class="statut-dot publie"></div>
            <div class="statut-info">
              <div class="statut-label">Publié</div>
              <div class="statut-desc">Visible par toutes les utilisatrices</div>
            </div>
          </label>
          <label class="statut-option {{ old('statut', $information->statut ?? 'brouillon') !== 'publie' ? 'selectionne' : '' }}"
                 id="opt-brouillon" onclick="selectionnerStatut('brouillon')">
            <input type="radio" name="statut" value="brouillon"
                   {{ old('statut', $information->statut ?? 'brouillon') !== 'publie' ? 'checked' : '' }}/>
            <div class="statut-dot brouillon"></div>
            <div class="statut-info">
              <div class="statut-label">Brouillon</div>
              <div class="statut-desc">Sauvegardé, non visible</div>
            </div>
          </label>
        </div>
        @error('statut') <div class="msg-erreur">{{ $message }}</div> @enderror
      </div>

      <!-- Actions -->
      <div class="form-actions">
        <button type="submit" class="btn-submit">
          {{ isset($information) ? '💾 Enregistrer les modifications' : '🚀 Publier l\'article' }}
        </button>
        <a href="{{ route('information.admin.index') }}" class="btn-annuler">Annuler</a>
      </div>

    </form>
  </div>
</div>

<script>
  function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    if (file) {
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    }
  }

  function selectionnerStatut(valeur) {
    document.getElementById('opt-publie').classList.toggle('selectionne', valeur === 'publie');
    document.getElementById('opt-brouillon').classList.toggle('selectionne', valeur === 'brouillon');
    document.querySelector(`input[value="${valeur}"]`).checked = true;
  }
</script>
</body>
</html>
