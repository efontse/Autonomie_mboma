<!-- Modal de confirmation personnalisée -->
<div id="confirm-modal" class="custom-modal" style="display: none;">
  <div class="custom-modal-overlay" onclick="closeConfirmModal()"></div>
  <div class="custom-modal-content">
    <div class="custom-modal-icon" id="confirm-modal-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>
    <h3 class="custom-modal-title" id="confirm-modal-title">Confirmation</h3>
    <p class="custom-modal-message" id="confirm-modal-message">Êtes-vous sûr de vouloir effectuer cette action ?</p>
    <div class="custom-modal-actions">
      <button class="custom-modal-btn custom-modal-btn-cancel" onclick="closeConfirmModal()">Annuler</button>
      <button class="custom-modal-btn custom-modal-btn-confirm" id="confirm-modal-btn" onclick="confirmAction()">Confirmer</button>
    </div>
  </div>
</div>

<style>
.custom-modal {
  position: fixed;
  inset: 0;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}

.custom-modal-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
}

.custom-modal-content {
  position: relative;
  background: white;
  border-radius: 16px;
  padding: 2rem;
  max-width: 400px;
  width: 90%;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
  animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.custom-modal-icon {
  width: 64px;
  height: 64px;
  margin: 0 auto 1rem;
  background: #FEE2E2;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.custom-modal-icon svg {
  width: 32px;
  height: 32px;
  color: #DC2626;
}

.custom-modal-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.5rem;
  font-weight: 700;
  color: #1C1008;
  margin-bottom: 0.5rem;
}

.custom-modal-message {
  color: #6B5B4E;
  font-size: 0.95rem;
  line-height: 1.5;
  margin-bottom: 1.5rem;
}

.custom-modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.custom-modal-btn {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
}

.custom-modal-btn-cancel {
  background: #E8E2D8;
  color: #6B5B4E;
}

.custom-modal-btn-cancel:hover {
  background: #D8D2C8;
}

.custom-modal-btn-confirm {
  background: #DC2626;
  color: white;
}

.custom-modal-btn-confirm:hover {
  background: #B91C1C;
}
</style>

<script>
let confirmCallback = null;

function openConfirmModal(message, callback, title = 'Confirmation') {
  document.getElementById('confirm-modal-message').textContent = message;
  document.getElementById('confirm-modal-title').textContent = title;
  confirmCallback = callback;
  document.getElementById('confirm-modal').style.display = 'flex';
}

function closeConfirmModal() {
  document.getElementById('confirm-modal').style.display = 'none';
  confirmCallback = null;
}

function confirmAction() {
  if (confirmCallback) {
    confirmCallback();
  }
  closeConfirmModal();
}

// Remplacer confirm() par notre modale
function customConfirm(message) {
  return new Promise((resolve) => {
    openConfirmModal(message, () => {
      resolve(true);
    }, 'Confirmation');
  });
}
</script>
