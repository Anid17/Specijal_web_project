document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('logoutBtn')?.addEventListener('click', () => {
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    window.location.reload();
  });

  document.getElementById('userRole').textContent = localStorage.getItem('role');
  loadUserInfo();
});

function loadUserInfo() {
  fetch(`${API_URL}/me`, {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('userName').textContent = data.name || 'Unknown';
      document.getElementById('userEmail').textContent = data.email || 'Unknown';
    });
}
