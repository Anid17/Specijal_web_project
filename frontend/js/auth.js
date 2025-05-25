// Store token and user in localStorage
function storeAuthData(token, user) {
  localStorage.setItem("token", token);
  localStorage.setItem("user", JSON.stringify(user));
}

// Get stored JWT
function getToken() {
  return localStorage.getItem("token");
}

// Get stored user object
function getUser() {
  const user = localStorage.getItem("user");
  return user ? JSON.parse(user) : null;
}

// Check login status
function isLoggedIn() {
  return !!getToken();
}

// Log out and redirect
function logout() {
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  window.location.href = "login.html";
}
