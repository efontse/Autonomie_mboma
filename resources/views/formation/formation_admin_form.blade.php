<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ isset($formation) ? 'Modifier' : 'Créer' }} une formation — Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --brun:#1C1008; --or:#C9923A; --ivoire:#FAF6F0; --creme:#F2EBE0;
      --blanc:#FFFFFF; --vert:#2A6049; --gris:#8A8278;
      --gris-clair:#E8E2D8; --texte:#2C1A0E; --texte-doux:#6B5B4E;
      --erreur:#C0392B; --sidebar-w:280px;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Outfit',sans-serif; background:var(--ivoire); color:var(--texte); }
    .page-wrap { margin-left:var(--sidebar-w); padding:2rem; min-height:100vh; }

    .retour { display:inline-flex; align-items:center; gap:0.5rem; color:var(--texte-doux); text-decoration:none; font-size:0.82rem; font-weight:500; margin-bottom:1.5rem; transition:color 0.2s; }
    .retour:hover { color:var(--or); }
    .retour svg { width:16px; height:16px; }

    .page-titre { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:700; margin-bottom:2rem; }

    .form-grid { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; align-items:start; }

    .form-card {
      background:var(--blanc); border-radius:16px;
      border:1px solid var(--gris-clair); padding:2rem;
    }
    .card-titre-section {
      font-family:'Cormorant Garamond',serif;
      font-size:1.1rem; font-weight:600; color:var(--texte);
      margin-bottom:1.2rem; padding-bottom:0.8rem;
      border-bottom:1px solid var(--gris-clair);
    }

    .champ { margin-bottom:1.3rem; }
    .champ label { display:block; font-size:0.82rem; font-weight:600; color:var(--texte); margin-bottom:0.4rem; }
    .requis { color:var(--or); }
    .aide { font-size:0.72rem; color:var(--gris); margin-top:0.3rem; }

    input[type="text"], input[type="url"], input[type="number"],
    select, textarea {
      width:100%; padding:0.72rem 1rem;
      border:1.5px solid var(--gris-clair); border-radius:9px;
      font-family:'Outfit',sans-serif; font-size:0.88rem;
      color:var(--texte); background:var(--blanc);
      outline:none; transition:border-color 0.2s; -webkit-appearance:none;
    }
    input:focus, select:focus, textarea:focus { border-color:var(--or); }
    textarea { resize:vertical; min-height:120px; line-height:1.6; }
    #contenu { min-height:200px; }

    /* Type formation */
    .type-grid { display:grid; grid-template-columns:1fr 1fr; gap:0.6rem; }
    .type-option {
      border:1.5px solid var(--gris-clair); border-radius:9px;
      padding:0.7rem 0.8rem; cursor:pointer; transition:all 0.2s;
      display:flex; align-items:center; gap:0.6rem;
    }
    .type-option input { display:none; }
    .type-option.sel { border-color:var(--or); background:rgba(201,146,58,0.06); }
    .type-option svg { width:18px; height:18px; color:var(--or); }
    .type-label { font-size:0.82rem; font-weight:500; color:var(--texte); }
    .type-desc  { font-size:0.7rem; color:var(--texte-doux); }

    /* Champs conditionnels */
    .champ-conditionnel { display:none; }
    .champ-conditionnel.visible { display:block; }

    /* Upload */
    .upload-zone {
      border:2px dashed var(--gris-clair); border-radius:9px;
      padding:1.5rem; text-align:center; cursor:pointer;
      transition:all 0.2s; position:relative;
    }
    .upload-zone:hover { border-color:var(--or); background:rgba(201,146,58,0.02); }
    .upload-zone input[type="file"] {
      position:absolute; inset:0; opacity:0; cursor:pointer;
      width:100%; height:100%; border:none; padding:0;
    }
    .upload-zone svg { width:28px; height:28px; margin:0 auto 0.5rem; display:block; color:var(--gris); opacity:0.5; }
    .upload-txt  { font-size:0.8rem; color:var(--texte-doux); }
    .upload-sous { font-size:0.7rem; color:var(--gris); margin-top:0.2rem; }
    .preview-img { max-width:100%; max-height:160px; border-radius:7px; margin-top:0.8rem; display:none; }

    /* Statut */
    .statut-wrap { display:flex; gap:0.7rem; }
    .statut-opt {
      flex:1; border:2px solid var(--gris-clair); border-radius:9px;
      padding:0.75rem; cursor:pointer; transition:all 0.2s;
      display:flex; align-items:center; gap:0.6rem;
    }
    .statut-opt input { display:none; }
    .statut-opt.sel { border-color:var(--vert); background:rgba(42,96,73,0.05); }
    .statut-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
    .statut-dot.publie   { background:#27AE60; }
    .statut-dot.brouillon { background:var(--gris); }
    .statut-lbl { font-size:0.82rem; font-weight:600; color:var(--texte); }
    .statut-desc-txt { font-size:0.7rem; color:var(--texte-doux); }

    /* Actions */
    .form-actions {
      display:flex; gap:0.8rem; padding-top:1.2rem;
      border-top:1px solid var(--gris-clair); margin-top:1.2rem;
    }
    .btn-save {
      padding:0.75rem 2rem; background:var(--brun); color:var(--blanc);
      border:none; border-radius:9px; font-family:'Outfit',sans-serif;
      font-size:0.88rem; font-weight:700; cursor:pointer; transition:all 0.2s;
    }
    .btn-save:hover { background:var(--or); }
    .btn-cancel {
      padding:0.75rem 1.3rem; background:transparent;
      border:1.5px solid var(--gris-clair); color:var(--texte-doux);
      border-radius:9px; font-family:'Outfit',sans-serif;
      font-size:0.88rem; cursor:pointer; text-decoration:none;
      display:inline-flex; align-items:center; transition:all 0.2s;
    }
    .btn-cancel:hover { background:var(--creme); }

    .msg-err { font-size:0.74rem; color:var(--erreur); margin-top:0.3rem; }
    .alerte-err { background:#fdecea; color:var(--erreur); border:1px solid #f5c6c2; border-radius:9px; padding:0.85rem 1.2rem; margin-bottom:1.5rem; font-size:0.84rem; }

    /* ── Sidebar ── */
    .sidebar {
      width: 280px;
      background: var(--blanc);
      border-right: 1px solid var(--gris-clair);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
      transition: transform 0.3s ease;
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
      background: #F0D9B5;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
    }
    .logo-text { display: flex; flex-direction: column; }
    .logo-name { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--brun); }
    .logo-sub { font-size: 0.7rem; color: var(--gris); text-transform: uppercase; letter-spacing: 0.1em; }

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
      background: linear-gradient(135deg, #2A6049, #3D8A68);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 700;
      color: var(--blanc);
      position: relative;
    }
    .avatar-status {
      position: absolute; bottom: 0; right: 0;
      width: 12px; height: 12px;
      background: #3D8A68;
      border-radius: 50%;
      border: 2px solid var(--blanc);
    }
    .profil-info { flex: 1; min-width: 0; }
    .profil-nom { font-weight: 600; font-size: 0.9rem; color: var(--texte); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .profil-role { font-size: 0.75rem; color: var(--gris); }

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
    }
    .btn-deconnexion:hover { background: #FEE2E2; border-color: #FCA5A5; color: #DC2626; }
    .btn-deconnexion svg { width: 16px; height: 16px; }

    /* Sous-menu */
    .nav-item.has-submenu { cursor: pointer; justify-content: flex-start; }
    .nav-item.has-submenu .submenu-arrow { width: 14px; height: 14px; margin-left: auto; transition: transform 0.2s; }
    .nav-item.has-submenu.open .submenu-arrow { transform: rotate(180deg); }
    .submenu { display: none; padding-left: 1rem; background: rgba(0,0,0,0.02); }
    .submenu.open { display: block; }
    .submenu-item { padding-left: 2.5rem; font-size: 0.8rem; }

    @media (max-width:900px) { .form-grid { grid-template-columns:1fr; } .sidebar { transform: translateX(-100%); } .sidebar.ouvert { transform: translateX(0); } .btn-menu-mobile { display: flex; } .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99; } .sidebar-overlay.visible { display: block; } }
    @media (max-width:768px) { .page-wrap { margin-left:0; padding:1.2rem; } .form-card { padding:1.3rem; } }

    /* Bouton menu mobile */
    .btn-menu-mobile {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.5rem;
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 101;
      background: var(--blanc);
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-menu-mobile svg { width: 24px; height: 24px; color: var(--texte); }
  </style>
</head>
<body>

@include('partials.sidebar')

<button class="btn-menu-mobile" onclick="ouvrirSidebar()">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <line x1="3" y1="12" x2="21" y2="12"/>
    <line x1="3" y1="6" x2="21" y2="6"/>
    <line x1="3" y1="18" x2="21" y2="18"/>
  </svg>
</button>

<div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>

<div class="page-wrap">

  <a href="{{ route('formation.admin.index') }}" class="retour">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Retour à la gestion
  </a>

  <h1 class="page-titre">
    {{ isset($formation) ? 'Modifier la formation' : 'Créer une nouvelle formation' }}
  </h1>

  @if($errors->any())
    <div class="alerte-err">❌ Veuillez corriger les erreurs ci-dessous.</div>
  @endif

  <form method="POST"
        action="{{ isset($formation) ? route('formation.admin.update', $formation) : route('formation.admin.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($formation)) @method('PUT') @endif

    <div class="form-grid">

      {{-- Colonne principale --}}
      <div style="display:flex;flex-direction:column;gap:1.2rem">

        <div class="form-card">
          <div class="card-titre-section">Informations générales</div>

          <div class="champ">
            <label for="titre">Titre <span class="requis">*</span></label>
            <input type="text" id="titre" name="titre"
                   value="{{ old('titre', $formation->titre ?? '') }}"
                   placeholder="Ex : Introduction au maraîchage biologique" required maxlength="255"/>
            @error('titre') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          <div class="champ">
            <label for="categorie_id">Catégorie <span class="requis">*</span></label>
            <select id="categorie_id" name="categorie_id" required>
              <option value="">— Choisir —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                  {{ old('categorie_id', $formation->categorie_id ?? '') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->nom }}
                </option>
              @endforeach
            </select>
            @error('categorie_id') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          <div class="champ">
            <label for="description">Description courte <span class="requis">*</span></label>
            <textarea id="description" name="description" required minlength="10"
                      placeholder="Résumez la formation en 2-3 phrases…">{{ old('description', $formation->description ?? '') }}</textarea>
            @error('description') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          <div class="champ">
            <label for="contenu">Contenu texte</label>
            <textarea id="contenu" name="contenu"
                      placeholder="Développez le contenu complet de la formation…">{{ old('contenu', $formation->contenu ?? '') }}</textarea>
            <div class="aide">Utilisable en complément d'une vidéo ou d'un PDF.</div>
            @error('contenu') <div class="msg-err">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-card">
          <div class="card-titre-section">Type de contenu</div>

          <div class="champ">
            <label>Type de formation <span class="requis">*</span></label>
            <div class="type-grid" id="type-grid">
              @foreach(['video'=>['Vidéo','Lien YouTube / externe','M_jVJU7vaz4'],'document'=>['Document PDF','Fichier PDF téléchargeable','M_jVJU7vaz4'],'article'=>['Article','Texte uniquement','M_jVJU7vaz4'],'mixte'=>['Mixte','Combiner plusieurs types','M_jVJU7vaz4']] as $val => [$lbl, $desc, $ico])
                <label class="type-option {{ old('type', $formation->type ?? 'article') === $val ? 'sel' : '' }}"
                       id="type-opt-{{ $val }}" onclick="selType('{{ $val }}')">
                  <input type="radio" name="type" value="{{ $val }}"
                         {{ old('type', $formation->type ?? 'article') === $val ? 'checked' : '' }}/>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    @if($val === 'video')   <polygon points="5 3 19 12 5 21 5 3"/> @endif
                    @if($val === 'document')<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/> @endif
                    @if($val === 'article') <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/> @endif
                    @if($val === 'mixte')  <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/> @endif
                  </svg>
                  <div>
                    <div class="type-label">{{ $lbl }}</div>
                    <div class="type-desc">{{ $desc }}</div>
                  </div>
                </label>
              @endforeach
            </div>
            @error('type') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          {{-- URL vidéo --}}
          <div class="champ champ-conditionnel" id="champ-video">
            <label for="video_url">URL de la vidéo YouTube</label>
            <input type="url" id="video_url" name="video_url"
                   value="{{ old('video_url', $formation->video_url ?? '') }}"
                   placeholder="https://www.youtube.com/watch?v=..."/>
            <div class="aide">Collez l'URL complète YouTube.</div>
            @error('video_url') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          {{-- Upload PDF --}}
          <div class="champ champ-conditionnel" id="champ-document">
            <label>Fichier PDF</label>
            <div class="upload-zone">
              <input type="file" name="document" accept="application/pdf" onchange="afficherNomFichier(event,'nom-pdf')"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <div class="upload-txt" id="nom-pdf">Cliquez pour choisir un PDF</div>
              <div class="upload-sous">PDF — max 10 Mo</div>
            </div>
            @if(isset($formation) && $formation->document_url)
              <div style="font-size:0.76rem;color:var(--texte-doux);margin-top:0.5rem">
                ✅ Fichier actuel : <a href="{{ asset($formation->document_url) }}" target="_blank" style="color:var(--or)">Voir le PDF</a>
              </div>
            @endif
            @error('document') <div class="msg-err">{{ $message }}</div> @enderror
          </div>
        </div>

      </div>

      {{-- Colonne latérale --}}
      <div style="display:flex;flex-direction:column;gap:1.2rem">

        <div class="form-card">
          <div class="card-titre-section">Paramètres</div>

          <div class="champ">
            <label for="niveau">Niveau <span class="requis">*</span></label>
            <select id="niveau" name="niveau" required>
              <option value="debutant"      {{ old('niveau', $formation->niveau ?? '') === 'debutant'      ? 'selected' : '' }}>Débutant</option>
              <option value="intermediaire" {{ old('niveau', $formation->niveau ?? '') === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
              <option value="avance"        {{ old('niveau', $formation->niveau ?? '') === 'avance'        ? 'selected' : '' }}>Avancé</option>
            </select>
            @error('niveau') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          <div class="champ">
            <label for="duree_minutes">Durée (en minutes)</label>
            <input type="number" id="duree_minutes" name="duree_minutes" min="1" max="9999"
                   value="{{ old('duree_minutes', $formation->duree_minutes ?? '') }}"
                   placeholder="Ex : 45"/>
            @error('duree_minutes') <div class="msg-err">{{ $message }}</div> @enderror
          </div>

          <div class="champ">
            <label>Statut <span class="requis">*</span></label>
            <div class="statut-wrap">
              <label class="statut-opt {{ old('statut', $formation->statut ?? '') === 'publie' ? 'sel' : '' }}"
                     id="s-publie" onclick="selStatut('publie')">
                <input type="radio" name="statut" value="publie"
                       {{ old('statut', $formation->statut ?? '') === 'publie' ? 'checked' : '' }}/>
                <div class="statut-dot publie"></div>
                <div>
                  <div class="statut-lbl">Publié</div>
                  <div class="statut-desc-txt">Visible</div>
                </div>
              </label>
              <label class="statut-opt {{ old('statut', $formation->statut ?? 'brouillon') !== 'publie' ? 'sel' : '' }}"
                     id="s-brouillon" onclick="selStatut('brouillon')">
                <input type="radio" name="statut" value="brouillon"
                       {{ old('statut', $formation->statut ?? 'brouillon') !== 'publie' ? 'checked' : '' }}/>
                <div class="statut-dot brouillon"></div>
                <div>
                  <div class="statut-lbl">Brouillon</div>
                  <div class="statut-desc-txt">Non visible</div>
                </div>
              </label>
            </div>
            @error('statut') <div class="msg-err">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-card">
          <div class="card-titre-section">Image de couverture</div>
          <div class="champ" style="margin-bottom:0">
            <div class="upload-zone">
              <input type="file" name="image" accept="image/*" onchange="previewImage(event)"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <div class="upload-txt">Cliquez pour choisir une image</div>
              <div class="upload-sous">JPEG, PNG, WebP — max 2 Mo</div>
              <img id="preview" class="preview-img" alt="Aperçu"/>
            </div>
            @if(isset($formation) && $formation->image_url)
              <div style="margin-top:0.6rem">
                <img src="{{ asset($formation->image_url) }}"
                     style="max-width:100%;border-radius:7px;max-height:120px;object-fit:cover"/>
              </div>
            @endif
            @error('image') <div class="msg-err">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-card">
          <div class="form-actions" style="border:none;padding:0;margin:0">
            <button type="submit" class="btn-save">
              {{ isset($formation) ? '💾 Enregistrer' : '🚀 Créer la formation' }}
            </button>
            <a href="{{ route('formation.admin.index') }}" class="btn-cancel">Annuler</a>
          </div>
        </div>

      </div>
    </div>

  </form>
</div>

<script>
  const typeActuel = '{{ old("type", isset($formation) ? $formation->type : "article") }}';

  function selType(val) {
    document.querySelectorAll('.type-option').forEach(el => el.classList.remove('sel'));
    document.getElementById('type-opt-' + val)?.classList.add('sel');
    document.querySelector(`input[value="${val}"][name="type"]`).checked = true;
    mettreAJourChamps(val);
  }

  function mettreAJourChamps(type) {
    const video    = document.getElementById('champ-video');
    const document_ = document.getElementById('champ-document');
    video.classList.remove('visible');
    document_.classList.remove('visible');
    if (type === 'video' || type === 'mixte')    video.classList.add('visible');
    if (type === 'document' || type === 'mixte') document_.classList.add('visible');
  }

  function selStatut(val) {
    document.getElementById('s-publie').classList.toggle('sel', val === 'publie');
    document.getElementById('s-brouillon').classList.toggle('sel', val === 'brouillon');
    document.querySelector(`input[value="${val}"][name="statut"]`).checked = true;
  }

  function previewImage(e) {
    const f = e.target.files[0];
    if (f) {
      const img = document.getElementById('preview');
      img.src = URL.createObjectURL(f);
      img.style.display = 'block';
    }
  }

  function afficherNomFichier(e, id) {
    const f = e.target.files[0];
    if (f) document.getElementById(id).textContent = '📄 ' + f.name;
  }

  // Init
  mettreAJourChamps(typeActuel);

  function toggleSubmenu(element) {
    element.classList.toggle('open');
    const submenu = element.nextElementSibling;
    submenu.classList.toggle('open');
  }
  function ouvrirSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('visible');
  }
  function fermerSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('visible');
  }
</script>
</body>
</html>
