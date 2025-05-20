// script.js
document.addEventListener('DOMContentLoaded', () => {
  const catList     = document.getElementById('categoryList');
  const threadDiv   = document.getElementById('threadList');
  const threadsCt   = document.getElementById('threadsContainer');
  const backBtn     = document.getElementById('backBtn');
  const toggle      = document.getElementById('searchToggle');
  const container   = document.querySelector('.search-container');
  const box         = document.getElementById('searchBox');
  const input       = document.getElementById('searchInput');
  const askCats     = document.getElementById('askCategories');
  const askInput    = document.getElementById('askCategoryInput');
  const userIcon    = document.querySelector('.user-icon');
  const userDrop    = document.querySelector('.user-dropdown');
  const defaultIcon = 'bi-book';
  const go          = document.getElementById('searchGo');
  // Search “Go” click
    // Search filter
  function doSearch() {
    const term = input.value.trim().toLowerCase();
    if (!term) {
    // no search term → go back to categories
    threadDiv.classList.add('d-none');
    catList.classList.remove('d-none');
    return;
  }
    const results = questions.filter(q=>q.title.toLowerCase().includes(term));
    showThreads('All');
    threadsCt.innerHTML = '';
    if (!results.length) {
      threadsCt.innerHTML = `<p class="text-center text-muted">No results for "${term}".</p>`;
    } else {
      results.forEach(q=>{
        const card = document.createElement('div');
        card.className = 'card question-card';
        card.innerHTML = `
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              <a href="thread.php?id=${q.questionID}">${q.title}</a>
            </h5>
            <p class="card-text small">
              <i class="bi bi-calendar-event"></i> ${q.postedAt}
            </p>
            <a href="thread.php?id=${q.questionID}"
               class="btn btn-outline-primary mt-auto rounded-pill">
               View Thread
            </a>
          </div>`;
        threadsCt.append(card);
      });
    }
  }
  
  go.addEventListener('click', doSearch);
  input.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      doSearch();
    }
    });

  // Build category list
  const counts = categories.reduce((acc,c)=>{
  acc[c.name] = questions.filter(q=>q.category===c.name).length;
  return acc;
}, {});
  // All button
  const allBtn = document.createElement('button');
  allBtn.className = 'btn category-btn active';
  allBtn.dataset.cat = 'All';
  allBtn.innerHTML = `
    <i class="bi ${defaultIcon} me-2"></i>All
    <span class="count">${questions.length}</span>`;
  allBtn.onclick = ()=>showThreads('All');
  catList.append(allBtn);
  allBtn.addEventListener('click', () => {
    backBtn.classList.remove('d-none');
    });

  categories.forEach(c=>{
  const name = c.name;
  const b    = document.createElement('button');
  b.className    = 'btn category-btn';
  b.dataset.cat  = name;
  b.innerHTML    = `
    <i class="bi ${defaultIcon} me-2 fs-3"></i>${name}
    <span class="count">${counts[name]||0}</span>`;
  b.onclick      = ()=>showThreads(name);
  b.addEventListener('click', ()=> backBtn.classList.remove('d-none'));
  catList.append(b);
});

  backBtn.addEventListener('click', () => {
  backBtn.classList.add('d-none');
});

  function showThreads(category) {
    Array.from(catList.children).forEach(b=>{
      b.classList.toggle('active', b.dataset.cat === category);
    });
    threadsCt.innerHTML = '';
    const list = category === 'All'
      ? questions
      : questions.filter(q=>q.category===category);
    if (!list.length) {
      threadsCt.innerHTML = `<p class="text-center text-muted">No threads in ${category}</p>`;
    } else {
      list.forEach(q=>{
        const card = document.createElement('div');
        card.className = 'card question-card';
        card.innerHTML = `
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              <a href="thread.php?id=${q.questionID}">${q.title}</a>
            </h5>
            <p class="card-text small">
              <i class="bi bi-calendar-event"></i> ${q.postedAt}
            </p>
            <a href="../pages/thread.php?id=${q.questionID}"
               class="btn btn-outline-primary mt-auto rounded-pill">
              View Thread
            </a>
          </div>`;
        threadsCt.append(card);
      });
    }
    catList.classList.add('d-none');
    threadDiv.classList.remove('d-none');
  }

  backBtn.addEventListener('click', e=>{
    e.preventDefault();
    threadDiv.classList.add('d-none');
    catList.classList.remove('d-none');
  });

  // Ask-form categories
  askCats.querySelectorAll('.ask-cat-btn').forEach(b=>{
  b.addEventListener('click', () => {
    askCats.querySelectorAll('button').forEach(x=>x.classList.remove('active'));
    b.classList.add('active');
    askInput.value = b.dataset.id;  // now this will be the real integer
  });
});

  // Animated search
  toggle.addEventListener('click', ()=>{
    container.classList.toggle('active');
    if (container.classList.contains('active')) {
      setTimeout(()=>input.focus(), 300);
    }
  });
  document.addEventListener('click', e=>{
    if (!box.contains(e.target) && !toggle.contains(e.target)) {
      container.classList.remove('active');
    }
  });

  userIcon.addEventListener('click', e => {
    e.stopPropagation();
    userDrop.classList.toggle('open');
  });
  document.addEventListener('click', () => userDrop.classList.remove('open'));
  });


  

