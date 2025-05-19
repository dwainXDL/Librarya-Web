document.getElementById('togglePwd').addEventListener('click', () => {
  const pwd = document.getElementById('passwordInput');
  pwd.type = pwd.type === 'password' ? 'text' : 'password';
});

document.getElementById('phoneNoInput').addEventListener('input', e => {
  e.target.value = e.target.value.replace(/\D/g,'');
});

