// script.js

// Overlay menu toggle
const menuToggle = document.getElementById('menu-toggle');
const menuOverlay = document.getElementById('menu-overlay');
const closeBtn = document.getElementById('close-btn');
  const userIcon    = document.querySelector('.user-icon');
  const userDrop    = document.querySelector('.user-dropdown');

menuToggle?.addEventListener('click', () => {
  menuOverlay.classList.add('open');
});

closeBtn?.addEventListener('click', () => {
  menuOverlay.classList.remove('open');
});

// Close overlay when clicking outside the menu-inner
menuOverlay?.addEventListener('click', e => {
  if (e.target === menuOverlay) {
    menuOverlay.classList.remove('open');
  }
});

  userIcon.addEventListener('click', e => {
    e.stopPropagation();
    userDrop.classList.toggle('open');
  });
  document.addEventListener('click', () => userDrop.classList.remove('open'));
