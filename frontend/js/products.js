const PRODUCTS_API = `${API_URL}/products`;

function fetchProducts() {
  fetch(PRODUCTS_API, {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  })
    .then(res => res.json())
    .then(data => renderProducts(data));
}

function renderProducts(products) {
  const container = document.getElementById('product-list');
  container.innerHTML = '';
  products.forEach(p => {
    container.innerHTML += `
      <div class="product-card">
        <h4>${p.name}</h4>
        <p>${p.description}</p>
        <p>${p.price} KM</p>
        ${localStorage.getItem('role') === 'admin' ? `
        <button onclick="deleteProduct(${p.id})">Delete</button>
        <button onclick="editProduct(${p.id})">Edit</button>` : ''}
      </div>
    `;
  });
}

function deleteProduct(id) {
  if (!confirm('Are you sure?')) return;
  fetch(`${PRODUCTS_API}/${id}`, {
    method: 'DELETE',
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  }).then(() => fetchProducts());
}

function addProduct(e) {
  e.preventDefault();
  const name = document.getElementById('product-name').value;
  const desc = document.getElementById('product-desc').value;
  const price = document.getElementById('product-price').value;

  if (!name || !desc || !price) {
    alert('All fields required!');
    return;
  }

  fetch(PRODUCTS_API, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ name, description: desc, price })
  }).then(() => {
    alert('Product added.');
    fetchProducts();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  fetchProducts();
  const form = document.getElementById('add-product-form');
  if (form) form.addEventListener('submit', addProduct);
});
