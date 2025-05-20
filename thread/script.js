// thread/script.js
document.addEventListener('DOMContentLoaded', () => {
  // Populate question
  document.getElementById('q-title').textContent    = question.title;
  document.getElementById('q-category').textContent = question.category;
  document.getElementById('q-author').textContent   = question.author;
  document.getElementById('q-postedAt').textContent = question.postedAt;
  document.getElementById('q-body').innerHTML       = question.body.replace(/\n/g,'<br>');
  const userIcon    = document.querySelector('.user-icon');
  const userDrop    = document.querySelector('.user-dropdown');

  userIcon.addEventListener('click', e => {
    e.stopPropagation();
    userDrop.classList.toggle('open');
  });
  document.addEventListener('click', () => userDrop.classList.remove('open'));

  // Populate replies
  const list = document.getElementById('replyList');
  if (!replies.length) {
    list.innerHTML = '<p class="text-center text-muted">No replies yet.</p>';
  } else {
    replies.forEach(r => {
      const card = document.createElement('div');
      card.className = 'card reply-card animate-fade-in-up p-3';
      card.innerHTML = `
        <p>${r.body}</p>
        <p class="text-muted small mb-0">By ${r.author} on ${r.postedAt}</p>`;
      list.append(card);
    });
  }
  document.getElementById('replyCount').textContent = replies.length;

  // Set hidden fields
  document.getElementById('questionID').value = question.questionID;
  document.getElementById('memberID').value   = memberID;
});
