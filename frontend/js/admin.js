document.addEventListener('DOMContentLoaded', () => {
  if (localStorage.getItem('role') !== 'admin') {
    alert("Access Denied");
    return;
  }

  fetchUsers();

  document.getElementById('add-user-form')?.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = document.getElementById('admin-user-name').value;
    const email = document.getElementById('admin-user-email').value;
    const password = document.getElementById('admin-user-password').value;
    const role = document.getElementById('admin-user-role').value;

    fetch(`${API_URL}/users`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({ name, email, password, role })
    }).then(() => fetchUsers());
  });
});

function fetchUsers() {
  fetch(`${API_URL}/users`, {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  })
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('user-list');
      container.innerHTML = '';
      data.forEach(u => {
        container.innerHTML += `
          <div class="user-card">
            <h5>${u.name} (${u.role})</h5>
            <p>${u.email}</p>
            <button onclick="deleteUser(${u.id})">Delete</button>
          </div>
        `;
      });
    });
}

function deleteUser(id) {
  fetch(`${API_URL}/users/${id}`, {
    method: 'DELETE',
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  }).then(() => fetchUsers());
}
