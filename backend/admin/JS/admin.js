const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle"); // Select the mode toggle button
      sidebar = body.querySelector("nav"); // Select the sidebar navigation
      sidebarToggle = body.querySelector(".sidebar-toggle"); // Select the sidebar toggle button

// Retrieve and apply the stored mode (dark/light) from localStorage
let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark"); // Apply dark mode if stored value is "dark"
}

// Retrieve and apply the stored sidebar status (close/open) from localStorage
let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close"); // Close sidebar if stored value is "close"
}

// Add event listener for mode toggle button
modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark"); // Toggle dark mode
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark"); // Store "dark" mode in localStorage
    }else{
        localStorage.setItem("mode", "light"); // Store "light" mode in localStorage
    }
});

// Add event listener for sidebar toggle button
sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close"); // Toggle sidebar close/open
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close"); // Store "close" status in localStorage
    }else{
        localStorage.setItem("status", "open"); // Store "open" status in localStorage
    }
});
