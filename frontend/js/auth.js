const API_URL = 'https://your-backend-url.com'; // Change to  actual backend URL

function validateLoginForm() {
  const email = document.getElementById('login-email')?.value || '';
  const password = document.getElementById('login-password')?.value || '';
  if (!email.includes('@') || password.length < 6) {
    alert('Please enter a valid email and password (min 6 characters).');
    return false;
  }
  return true;
}

function loginUser(e) {
  e.preventDefault();
  if (!validateLoginForm()) return;

  fetch(`${API_URL}/login`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: document.getElementById('login-email').value,
      password: document.getElementById('login-password').value
    })
  })
    .then(res => res.json())
    .then(data => {
      if (data.token) {
        localStorage.setItem('token', data.token);
        localStorage.setItem('role', data.role);
        alert('Login successful!');
        loadDashboard(); // or redirect to dashboard
      } else {
        alert('Login failed!');
      }
    });
}

function registerUser(e) {
  e.preventDefault();

  const email = document.getElementById('register-email')?.value || '';
  const password = document.getElementById('register-password')?.value || '';
  const name = document.getElementById('register-name')?.value || '';

  if (!email || password.length < 6 || !name) {
    alert('Fill all fields properly.');
    return;
  }

  fetch(`${API_URL}/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name, email, password })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Registered successfully. Please log in.');
      } else {
        alert(data.message || 'Registration failed.');
      }
    });
}

document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');

  if (loginForm) loginForm.addEventListener('submit', loginUser);
  if (registerForm) registerForm.addEventListener('submit', registerUser);
});
