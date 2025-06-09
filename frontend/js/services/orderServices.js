
const API_BASE = "https://your-api-domain.com"; // replace on deploy
const token = localStorage.getItem("token");

export async function placeOrder(orderData) {
  const response = await fetch(`${API_BASE}/orders`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${token}`
    },
    body: JSON.stringify(orderData)
  });
  return await response.json();
}

export async function getUserOrders(userId) {
  const response = await fetch(`${API_BASE}/orders/user/${userId}`, {
    headers: {
      "Authorization": `Bearer ${token}`
    }
  });
  return await response.json();
}

export async function getAllOrders() {
  const response = await fetch(`${API_BASE}/orders`, {
    headers: {
      "Authorization": `Bearer ${token}`
    }
  });
  return await response.json();
}
