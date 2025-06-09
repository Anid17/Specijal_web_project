
const API_BASE = "https://your-api-domain.com"; // Update on deployment

export async function loginUser(email, password) {
  const response = await fetch(`${API_BASE}/login`, {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ email, password })
  });
  return await response.json();
}

export function saveUserToStorage(user, token) {
  localStorage.setItem("user", JSON.stringify(user));
  localStorage.setItem("token", token);
}

export function logoutUser() {
  localStorage.removeItem("user");
  localStorage.removeItem("token");
}
