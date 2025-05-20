document.addEventListener('DOMContentLoaded', () => {
  const list        = document.getElementById('book-list');
  const modal       = document.getElementById('book-modal');
  const backdrop    = modal.querySelector('.modal-backdrop');
  const searchIcon  = document.querySelector('.search-icon');
  const searchInput = document.getElementById('search-input');
  const userIcon    = document.querySelector('.user-icon');
  const userDrop    = document.querySelector('.user-dropdown');
  const searchContainer = document.querySelector('.search-container');

  let booksData = [];

  const esc = s => String(s)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');

  fetch('../books/process.php')
    .then(r => r.json())
    .then(data => {
      booksData = Array.isArray(data) ? data : [];
      renderBooks(booksData);
    })
    .catch(() => list.innerHTML = '<p class="error-msg">Error loading books.</p>');

  function renderBooks(arr) {
    list.innerHTML = '';
    if (!arr.length) {
      list.innerHTML = '<p class="error-msg"></p>';
      return;
    }
    arr.forEach(b => {
      const card = document.createElement('div');
      card.className = 'book-card';
      card.innerHTML = `
        <div class="cover-wrapper">
          <img src="${esc(b.cover)}" alt="${esc(b.title)}">
        </div>`;
      card.addEventListener('click', () => openModal(b));
      list.appendChild(card);
    });
  }

  function openModal(b) {
    modal.classList.add('open');
    modal.querySelector('#modal-cover').src         = b.cover;
    modal.querySelector('#modal-title').textContent = b.title;
    modal.querySelector('#modal-isbn').textContent  = b.isbn;
    modal.querySelector('#modal-author').textContent= b.author;
    modal.querySelector('#modal-category').textContent = b.category;
    modal.querySelector('#modal-language').textContent = b.language;
    modal.querySelector('#modal-year').textContent     = b.year;
    modal.querySelector('#modal-description').textContent = b.description;
    modal.querySelector('#modal-availability').textContent= b.availability;
  }

  backdrop.addEventListener('click', () => modal.classList.remove('open'));
  modal.addEventListener('click', e => {
    if (e.target === modal) modal.classList.remove('open');
  });

  searchIcon.addEventListener('click', () => {
    searchInput.classList.toggle('search-input-expanded');
    searchInput.classList.toggle('search-input-collapsed');
    if (searchInput.classList.contains('search-input-expanded')) {
      searchInput.focus();
    } else {
      searchInput.value = '';
      renderBooks(booksData);
    }
  });

  searchContainer.addEventListener('click', e => {
    e.stopPropagation();
  });

  document.addEventListener('click', () => {
    if (searchInput.classList.contains('search-input-expanded')) {
      // collapse it
      searchInput.classList.remove('search-input-expanded');
      searchInput.classList.add('search-input-collapsed');
      searchInput.value = '';
      renderBooks(booksData);
    }
  });

  searchInput.addEventListener('input', () => {
    const q = searchInput.value.trim().toLowerCase();
    renderBooks(
      booksData.filter(b =>
        b.title.toLowerCase().includes(q) ||
        b.author.toLowerCase().includes(q)
      )
    );
  });

  userIcon.addEventListener('click', e => {
    e.stopPropagation();
    userDrop.classList.toggle('open');
  });
  document.addEventListener('click', () => userDrop.classList.remove('open'));
});


