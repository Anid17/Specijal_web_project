// Function to load page content
function loadPage(page) {
    const contentDiv = document.getElementById("content");

    // Clear the existing content with fade-out effect
    contentDiv.classList.add('fade-out');

    setTimeout(() => {
        // Fetch the new page content
        fetch(`${page}.html`)
            .then(response => response.text())
            .then(data => {
                // Set the new content inside the main page div
                contentDiv.innerHTML = data;

                // After content is updated, add the fade-in effect
                contentDiv.classList.remove('fade-out');
                contentDiv.classList.add('fade-in');

                // Initialize any specific functionality for the loaded page
                if (page === "contact") {
                    initMap();
                }

                // Run scroll animation for newly loaded content
                revealSections();
            })
            .catch(error => {
                console.error('Error loading the page:', error);
                contentDiv.innerHTML = "<h1>Page Not Found</h1>";
            });
    }, 300); // Wait for fade-out to finish before changing content
}


// Add event listeners for navigation
document.getElementById("home")?.addEventListener("click", () => loadPage("home"));
document.getElementById("productsLink")?.addEventListener("click", () => loadPage("productsLink"));
document.getElementById("orderLink")?.addEventListener("click", () => loadPage("order"));
document.getElementById("aboutLink")?.addEventListener("click", () => loadPage("about"));
document.getElementById("contactLink")?.addEventListener("click", () => loadPage("contact"));
document.getElementById("loginLink")?.addEventListener("click", () => loadPage("login"));


// Load home page by default
window.onload = function () {
    loadPage("home");
};


// Scroll Animation - Fade-in Sections
function revealSections() {
    let sections = document.querySelectorAll("section");
    sections.forEach((section) => {
        let sectionTop = section.getBoundingClientRect().top;
        let triggerPoint = window.innerHeight * 0.85;
        if (sectionTop < triggerPoint) {
            section.classList.add("show");
        }
    });
}

// Listen for scroll to reveal sections
window.addEventListener("scroll", revealSections);


document.addEventListener('DOMContentLoaded', () => {
  const token = localStorage.getItem('token');
  if (token) {
    loadDashboard();
  } else {
    loadLogin();
  }
});

function loadDashboard() {
  fetch('views/dashboard.html')
    .then(res => res.text())
    .then(html => {
      document.getElementById('app').innerHTML = html;
      // Load JS per view
      const script = document.createElement('script');
      script.src = 'js/dashboard.js';
      document.body.appendChild(script);
    });
}

function loadLogin() {
  fetch('views/login.html')
    .then(res => res.text())
    .then(html => {
      document.getElementById('app').innerHTML = html;
    });
}
