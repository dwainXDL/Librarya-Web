document.getElementById('togglePwd').addEventListener('click', () => {
  const pwd = document.getElementById('passwordInput');
  const icon = document.querySelector('#togglePwd i');
  if (pwd.type === 'password') {
    pwd.type = 'text';
    icon.classList.replace('bi-eye-fill','bi-eye-slash-fill');
  } else {
    pwd.type = 'password';
    icon.classList.replace('bi-eye-slash-fill','bi-eye-fill');
  }
});

const inputs = document.querySelectorAll('input[required]');
const btn    = document.querySelector('.btn-submit');
function checkInputs() {
  btn.disabled = ![...inputs].every(i => i.value.trim() !== '');
}
inputs.forEach(i => i.addEventListener('input', checkInputs));
document.addEventListener('DOMContentLoaded', checkInputs);