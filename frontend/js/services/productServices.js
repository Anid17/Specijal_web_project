
const API_BASE = "https://your-api-domain.com";
const token = localStorage.getItem("token");

export async function getProducts() {
  const res = await fetch(`${API_BASE}/products`, {
    headers: {
      "Authorization": `Bearer ${token}`
    }
  });
  return await res.json();
}
