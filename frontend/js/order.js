document.addEventListener('DOMContentLoaded', () => {
  fetchOrders();
  document.getElementById('order-form')?.addEventListener('submit', addOrder);
});

function fetchOrders() {
  fetch(`${API_URL}/orders`, {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  })
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('order-list');
      container.innerHTML = '';
      data.forEach(o => {
        container.innerHTML += `
          <div class="order-item">
            <p><strong>Order #${o.id}</strong> for ${o.product_name}</p>
            <p>Status: ${o.status}</p>
            ${localStorage.getItem('role') === 'admin' ? `
              <button onclick="deleteOrder(${o.id})">Delete</button>
              <button onclick="updateOrderStatus(${o.id})">Mark Done</button>
            ` : ''}
          </div>
        `;
      });
    });
}

function addOrder(e) {
  e.preventDefault();
  const productId = document.getElementById('order-product-id').value;
  fetch(`${API_URL}/orders`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${localStorage.getItem('token')}`
    },
    body: JSON.stringify({ product_id: productId })
  }).then(() => {
    alert('Order placed!');
    fetchOrders();
  });
}

function deleteOrder(id) {
  fetch(`${API_URL}/orders/${id}`, {
    method: 'DELETE',
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  }).then(() => fetchOrders());
}

function updateOrderStatus(id) {
  fetch(`${API_URL}/orders/${id}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${localStorage.getItem('token')}`
    },
    body: JSON.stringify({ status: 'completed' })
  }).then(() => fetchOrders());
}
