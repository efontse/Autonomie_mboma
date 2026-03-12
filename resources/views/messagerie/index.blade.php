<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messagerie — Plateforme Mboma</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --terre:#8B4513; --savane:#C8860A; --ocre:#D4A853;
      --creme:#FDF6EC; --vert:#2D6A4F; --vert-clair:#52B788;
      --brun-fonce:#3B1F0A; --blanc:#FFFFFF; --gris:#6B6B6B;
      --gris-clair:#F0EAE0;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--creme);
      min-height: 100vh;
    }
    .header {
      background: var(--brun-fonce);
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .header h1 {
      font-family: 'Playfair Display', serif;
      color: var(--blanc);
      font-size: 1.3rem;
    }
    .header a {
      color: var(--ocre);
      text-decoration: none;
      font-size: 0.9rem;
      margin-left: auto;
    }

    .messagerie-container {
      display: grid;
      grid-template-columns: 280px 320px 1fr;
      height: calc(100vh - 60px);
      max-width: 1400px;
      margin: 0 auto;
      background: var(--blanc);
    }

    /* Sidebar utilisateurs */
    .sidebar-users {
      border-right: 1px solid var(--gris-clair);
      overflow-y: auto;
    }
    .sidebar-header {
      padding: 1rem;
      border-bottom: 1px solid var(--gris-clair);
      font-weight: 600;
      color: var(--brun-fonce);
    }
    .user-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1rem;
      cursor: pointer;
      transition: background 0.2s;
    }
    .user-item:hover {
      background: var(--gris-clair);
    }
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--savane), var(--ocre));
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blanc);
      font-weight: 600;
      position: relative;
    }
    .user-avatar .status {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--vert-clair);
      border: 2px solid var(--blanc);
    }
    .user-info {
      flex: 1;
      min-width: 0;
    }
    .user-name {
      font-weight: 600;
      color: var(--brun-fonce);
      font-size: 0.9rem;
    }
    .user-preview {
      font-size: 0.8rem;
      color: var(--gris);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* Liste conversations */
    .conversations-list {
      border-right: 1px solid var(--gris-clair);
      overflow-y: auto;
    }
    .conv-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1rem;
      cursor: pointer;
      border-bottom: 1px solid var(--gris-clair);
      transition: background 0.2s;
    }
    .conv-item:hover, .conv-item.active {
      background: var(--gris-clair);
    }
    .conv-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--savane), var(--ocre));
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blanc);
      font-weight: 600;
      position: relative;
      cursor: pointer;
      text-decoration: none;
    }
    .conv-avatar:hover {
      transform: scale(1.05);
    }
    .conv-avatar .unread-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--vert);
      color: var(--blanc);
      font-size: 0.7rem;
      padding: 0.15rem 0.4rem;
      border-radius: 10px;
      min-width: 18px;
      text-align: center;
    }
    .conv-info {
      flex: 1;
      min-width: 0;
    }
    .conv-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .conv-name {
      font-weight: 600;
      color: var(--brun-fonce);
      font-size: 0.9rem;
    }
    .conv-time {
      font-size: 0.7rem;
      color: var(--gris);
    }
    .conv-preview {
      font-size: 0.8rem;
      color: var(--gris);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .conv-item.active .conv-preview {
      color: var(--vert);
      font-weight: 500;
    }

    /* Zone de chat */
    .chat-area {
      display: flex;
      flex-direction: column;
      background: var(--creme);
    }
    .chat-header {
      padding: 1rem;
      background: var(--blanc);
      border-bottom: 1px solid var(--gris-clair);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .chat-header-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--savane), var(--ocre));
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blanc);
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
    }
    .chat-header-avatar:hover {
      transform: scale(1.05);
    }
    .chat-header-info h3 {
      font-size: 1rem;
      color: var(--brun-fonce);
    }
    .chat-header-info span {
      font-size: 0.8rem;
      color: var(--gris);
    }
    .chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }
    .message {
      max-width: 70%;
      display: flex;
      flex-direction: column;
    }
    .message.sent {
      align-self: flex-end;
    }
    .message.received {
      align-self: flex-start;
    }
    .message-bubble {
      padding: 0.75rem 1rem;
      border-radius: 18px;
      font-size: 0.9rem;
      line-height: 1.4;
    }
    .message.sent .message-bubble {
      background: var(--vert);
      color: var(--blanc);
      border-bottom-right-radius: 4px;
    }
    .message.received .message-bubble {
      background: var(--blanc);
      color: var(--brun-fonce);
      border-bottom-left-radius: 4px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .message-time {
      font-size: 0.7rem;
      color: var(--gris);
      margin-top: 0.25rem;
    }
    .message.sent .message-time {
      text-align: right;
    }
    .message.received .message-time {
      text-align: left;
    }
    .message-status {
      font-size: 0.7rem;
      color: var(--gris);
    }
    .message.sent .message-status {
      text-align: right;
    }

    /* Indicateur lu */
    .message.lu .message-bubble {
      background: var(--vert-clair);
    }

    /* Zone de saisie */
    .chat-input {
      padding: 1rem;
      background: var(--blanc);
      border-top: 1px solid var(--gris-clair);
      display: flex;
      gap: 0.75rem;
    }
    .chat-input input {
      flex: 1;
      border: 1px solid var(--gris-clair);
      border-radius: 25px;
      padding: 0.75rem 1rem;
      font-family: inherit;
      font-size: 0.9rem;
      outline: none;
    }
    .chat-input input:focus {
      border-color: var(--vert);
    }
    .chat-input button {
      background: var(--vert);
      color: var(--blanc);
      border: none;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }
    .chat-input button:hover {
      background: #1a5c3a;
      transform: scale(1.05);
    }

    /* Empty state */
    .empty-chat {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: var(--gris);
    }
    .empty-chat i {
      font-size: 4rem;
      margin-bottom: 1rem;
      color: var(--gris-clair);
    }

    /* Modal pour nouvelle conversation */
    .new-chat-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }
    .new-chat-modal.active {
      display: flex;
    }
    .modal-content {
      background: var(--blanc);
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      max-height: 80vh;
      display: flex;
      flex-direction: column;
    }
    .modal-header {
      padding: 1rem;
      border-bottom: 1px solid var(--gris-clair);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .modal-header h3 {
      color: var(--brun-fonce);
    }
    .modal-close {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--gris);
    }
    .modal-body {
      padding: 1rem;
      overflow-y: auto;
      flex: 1;
    }
    .user-search {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gris-clair);
      border-radius: 8px;
      margin-bottom: 1rem;
      font-family: inherit;
    }
    .user-search:focus {
      outline: none;
      border-color: var(--vert);
    }
    .user-list-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem;
      cursor: pointer;
      border-radius: 8px;
      transition: background 0.2s;
    }
    .user-list-item:hover {
      background: var(--gris-clair);
    }

    @media (max-width: 900px) {
      .messagerie-container {
        grid-template-columns: 1fr;
      }
      .sidebar-users, .conversations-list {
        display: none;
      }
    }
  </style>
</head>
<body>
<div class="header">
  <i class="bi bi-chat-dots" style="color: var(--ocre); font-size: 1.5rem;"></i>
  <h1>Messagerie</h1>
  <a href="{{ route('dashboard') }}"><i class="bi bi-arrow-left"></i> Retour au tableau de bord</a>
</div>

<div class="messagerie-container">
  <!-- Sidebar utilisateurs -->
  <div class="sidebar-users">
    <div class="sidebar-header" style="display:flex; justify-content:space-between; align-items:center;">
      <span><i class="bi bi-people"></i> Utilisateurs</span>
      <button onclick="if(typeof openNewChatModal === 'function'){openNewChatModal();}else{alert('Chargement...')}" style="background:none; border:none; cursor:pointer; color:var(--vert); font-size:1.2rem;" title="Nouvelle conversation">
        <i class="bi bi-plus-circle"></i>
      </button>
    </div>
    <div id="users-list">
      <!-- Liste des utilisateurs chargée via JS -->
    </div>
  </div>

  <!-- Liste des conversations -->
  <div class="conversations-list">
    @forelse($conversations as $conv)
      <div class="conv-item {{ isset($conversation) && $conversation->id == $conv->id ? 'active' : '' }}" style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; cursor:pointer; border-bottom:1px solid var(--gris-clair);" onclick="window.location='{{ route('messagerie.show', $conv->id) }}'">
        <div class="conv-avatar" onclick='event.stopPropagation(); alert("Profil de {{ $conv->autre->prenom ?? 'cet utilisateur' }}");'>
          {{ $conv->autre->prenom ? $conv->autre->prenom[0] : 'U' }}
          @if($conv->non_lus > 0)
            <span class="unread-badge">{{ $conv->non_lus }}</span>
          @endif
        </div>
        <div class="conv-info">
          <div class="conv-header">
            <span class="conv-name">{{ $conv->autre->prenom ?? 'Utilisateur' }} {{ $conv->autre->nom ?? '' }}</span>
            <span class="conv-time">{{ $conv->dernierMessage ? $conv->dernierMessage->created_at->diffForHumans() : '' }}</span>
          </div>
          <div class="conv-preview">{{ $conv->dernierMessage ? Str::limit($conv->dernierMessage->contenu, 40) : 'Aucun message' }}</div>
        </div>
      </div>
    @empty
      <div style="padding: 2rem; text-align: center; color: var(--gris);">
        <i class="bi bi-chat" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <p>Aucune conversation</p>
      </div>
    @endforelse
  </div>

  <!-- Zone de chat -->
  <div class="chat-area">
    @if(isset($conversation))
      <div class="chat-header">
        <a href="#" class="chat-header-avatar" onclick='alert("Profil de {{ $conversation->autre->prenom ?? 'cet utilisateur' }}")'>{{ $conversation->autre->prenom ? $conversation->autre->prenom[0] : 'U' }}</a>
        <div class="chat-header-info">
          <h3>{{ $conversation->autre->prenom ?? 'Utilisateur' }} {{ $conversation->autre->nom ?? '' }}</h3>
          <span>En ligne</span>
        </div>
      </div>
      <div class="chat-messages" id="chat-messages">
        @foreach($conversation->messages as $message)
          <div class="message {{ $message->user_id == Auth::id() ? 'sent' : 'received' }} {{ $message->est_lu && $message->user_id == Auth::id() ? 'lu' : '' }}">
            <div class="message-bubble">{{ $message->contenu }}</div>
            <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
            @if($message->user_id == Auth::id())
              <div class="message-status">{{ $message->est_lu ? '<i class="bi bi-check-all"></i>' : '<i class="bi bi-check"></i>' }}</div>
            @endif
          </div>
        @endforeach
      </div>
      <form class="chat-input" id="message-form">
        @csrf
        <input type="text" id="message-input" placeholder="Écrire un message..." autocomplete="off">
        <button type="submit"><i class="bi bi-send"></i></button>
      </form>
    @else
      <div class="empty-chat">
        <i class="bi bi-chat-dots"></i>
        <p>Sélectionnez une conversation</p>
      </div>
    @endif
  </div>
</div>

<script>
  // Définir les fonctions en premier
  function openNewChatModal() {
    const modal = document.getElementById('new-chat-modal');
    if (modal) {
      modal.classList.add('active');
      loadUsersForModal();
    }
  }

  function closeNewChatModal() {
    const modal = document.getElementById('new-chat-modal');
    if (modal) {
      modal.classList.remove('active');
    }
  }

  let allUsers = [];
  let modalUsers = [];

  async function loadUsers() {
    try {
      const response = await fetch('{{ route('messagerie.api.utilisateurs') }}', {
        headers: {
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success) {
        allUsers = data.users;
        displayUsers(allUsers);
      }
    } catch (error) {
      console.error('Erreur chargement utilisateurs:', error);
    }
  }

  function displayUsers(users) {
    const container = document.getElementById('users-list');
    if (!users || users.length === 0) {
      container.innerHTML = '<div style="padding:1rem; text-align:center; color:var(--gris);">Aucun utilisateur</div>';
      return;
    }

    container.innerHTML = users.map(user => `
      <div class="user-item" onclick="startConversation(${user.id})">
        <div class="user-avatar">
          ${user.prenom ? user.prenom[0].toUpperCase() : 'U'}
        </div>
        <div class="user-info">
          <div class="user-name">${user.prenom || 'Utilisateur'} ${user.nom || ''}</div>
          <div class="user-preview">${user.role || ''}</div>
        </div>
      </div>
    `).join('');
  }

  async function startConversation(userId) {
    try {
      const response = await fetch(`/messagerie/demarrer/${userId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success || response.ok) {
        window.location.href = `/messagerie/${data.conversation_id || userId}`;
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  }

  async function loadUsersForModal() {
    try {
      const response = await fetch('{{ route('messagerie.api.utilisateurs') }}', {
        headers: {
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success) {
        modalUsers = data.users;
        displayModalUsers(modalUsers);
      }
    } catch (error) {
      console.error('Erreur chargement utilisateurs:', error);
    }
  }

  function displayModalUsers(users) {
    const container = document.getElementById('modal-users-list');
    if (!users || users.length === 0) {
      container.innerHTML = '<div style="padding:1rem; text-align:center; color:var(--gris);">Aucun utilisateur disponible</div>';
      return;
    }

    container.innerHTML = users.map(user => `
      <div class="user-list-item" onclick="startConversation(${user.id}); closeNewChatModal();">
        <div class="user-avatar">
          ${user.prenom ? user.prenom[0].toUpperCase() : 'U'}
        </div>
        <div class="user-info">
          <div class="user-name">${user.prenom || 'Utilisateur'} ${user.nom || ''}</div>
          <div class="user-preview" style="font-size:0.8rem; color:var(--gris);">${user.role || ''}</div>
        </div>
      </div>
    `).join('');
  }

  function filterModalUsers(searchTerm) {
    const filtered = modalUsers.filter(user => {
      const fullName = `${user.prenom || ''} ${user.nom || ''}`.toLowerCase();
      return fullName.includes(searchTerm.toLowerCase());
    });
    displayModalUsers(filtered);
  }

  // Charger les utilisateurs au démarrage
  document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
  });

  const conversationId = {{ isset($conversation) && $conversation ? $conversation->id : 'null' }};

  // Auto-scroll vers le bas
  if (document.getElementById('chat-messages')) {
    const messagesContainer = document.getElementById('chat-messages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  // Envoyer message avec Entrée
  document.getElementById('message-input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      document.getElementById('message-form').dispatchEvent(new Event('submit'));
    }
  });

  // Soumettre le formulaire
  document.getElementById('message-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const input = document.getElementById('message-input');
    const contenu = input.value.trim();

    if (!contenu || !conversationId) return;

    try {
      const response = await fetch(`/messagerie/${conversationId}/messages`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ contenu: contenu })
      });

      const data = await response.json();

      if (data.success) {
        input.value = '';

        // Ajouter le message à l'affichage
        const messagesContainer = document.getElementById('chat-messages');
        const messageHtml = `
          <div class="message sent">
            <div class="message-bubble">${data.message.contenu}</div>
            <div class="message-time">À l'instant</div>
            <div class="message-status"><i class="bi bi-check"></i></div>
          </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  });

  // Poll pour nouveaux messages
  if (conversationId) {
    setInterval(async () => {
      try {
        const response = await fetch(`/messagerie/${conversationId}/messages`);
        const data = await response.json();

        if (data.success) {
          // Mettre à jour les messages si nouveaux
          // Logique à implémenter selon les besoins
        }
      } catch (error) {
        // Silence
      }
    }, 5000);
  }

  // Charger les utilisateurs au démarrage
  // La variable allUsers est déjà déclarée plus haut

  // Ajouter l'écouteur d'événement pour le bouton nouvelle conversation
  document.getElementById('new-chat-btn')?.addEventListener('click', openNewChatModal);

async function loadUsers() {
    try {
      const response = await fetch('{{ route('messagerie.api.utilisateurs') }}', {
        headers: {
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success) {
        allUsers = data.users;
        displayUsers(allUsers);
      }
    } catch (error) {
      console.error('Erreur chargement utilisateurs:', error);
    }
  }

  function displayUsers(users) {
    const container = document.getElementById('users-list');
    if (!users || users.length === 0) {
      container.innerHTML = '<div style="padding:1rem; text-align:center; color:var(--gris);">Aucun utilisateur</div>';
      return;
    }

    container.innerHTML = users.map(user => `
      <div class="user-item" onclick="startConversation(${user.id})">
        <div class="user-avatar">
          ${user.prenom ? user.prenom[0].toUpperCase() : 'U'}
        </div>
        <div class="user-info">
          <div class="user-name">${user.prenom || 'Utilisateur'} ${user.nom || ''}</div>
          <div class="user-preview">${user.role || ''}</div>
        </div>
      </div>
    `).join('');
  }

  async function startConversation(userId) {
    try {
      const response = await fetch(`/messagerie/demarrer/${userId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success || response.ok) {
        window.location.href = `/messagerie/${data.conversation_id || userId}`;
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  }

  function openNewChatModal() {
    const modal = document.getElementById('new-chat-modal');
    if (modal) {
      modal.classList.add('active');
      loadUsersForModal();
    }
  }

  function closeNewChatModal() {
    const modal = document.getElementById('new-chat-modal');
    if (modal) {
      modal.classList.remove('active');
    }
  }

  // La variable modalUsers est déjà déclarée plus haut

  async function loadUsersForModal() {
    try {
      const response = await fetch('{{ route('messagerie.api.utilisateurs') }}', {
        headers: {
          'Accept': 'application/json',
        }
      });
      const data = await response.json();
      if (data.success) {
        modalUsers = data.users;
        displayModalUsers(modalUsers);
      }
    } catch (error) {
      console.error('Erreur chargement utilisateurs:', error);
    }
  }

  function displayModalUsers(users) {
    const container = document.getElementById('modal-users-list');
    if (!users || users.length === 0) {
      container.innerHTML = '<div style="padding:1rem; text-align:center; color:var(--gris);">Aucun utilisateur disponible</div>';
      return;
    }

    container.innerHTML = users.map(user => `
      <div class="user-list-item" onclick="startConversation(${user.id}); closeNewChatModal();">
        <div class="user-avatar">
          ${user.prenom ? user.prenom[0].toUpperCase() : 'U'}
        </div>
        <div class="user-info">
          <div class="user-name">${user.prenom || 'Utilisateur'} ${user.nom || ''}</div>
          <div class="user-preview" style="font-size:0.8rem; color:var(--gris);">${user.role || ''}</div>
        </div>
      </div>
    `).join('');
  }

  function filterModalUsers(searchTerm) {
    const filtered = modalUsers.filter(user => {
      const fullName = `${user.prenom || ''} ${user.nom || ''}`.toLowerCase();
      return fullName.includes(searchTerm.toLowerCase());
    });
    displayModalUsers(filtered);
  }

  // Charger les utilisateurs au démarrage
  loadUsers();
</script>

<!-- Modal pour nouvelle conversation -->
<div class="new-chat-modal" id="new-chat-modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Nouvelle conversation</h3>
      <button class="modal-close" onclick="closeNewChatModal()">&times;</button>
    </div>
    <div class="modal-body">
      <input type="text" class="user-search" placeholder="Rechercher un utilisateur..." oninput="filterModalUsers(this.value)">
      <div id="modal-users-list">
        <!-- Liste des utilisateurs -->
      </div>
    </div>
  </div>
</div>
</body>
</html>
