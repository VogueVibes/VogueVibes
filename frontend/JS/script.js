const navbar = document.querySelector('.my-navbar');
const menu = document.querySelector('.menu');
const catalogMenu = document.querySelector('.catalog-menu');
const catalogBtn = document.querySelector('.btn-left');
let isCatalogMenuOpen = false;

// Function to check if the current URL is the home page
function isHomePage() {
  return window.location.pathname === '/vogueVibes_New/frontend/pages/index.php';
}

// Function to check if the current URL is the about us page
function isAboutUs() {
  return window.location.pathname === '/vogueVibes_New/frontend/pages/aboutus.php';
}

// Function to check if the current URL is the catalogue page
function isCatalogue() {
  return window.location.pathname === '/vogueVibes_New/frontend/catalogue.php';
}

// Function to check if the current URL is the help page
function isHelp() {
  return window.location.pathname === '/vogueVibes_New/frontend/helpPage.php';
}

const vogueVibes = document.querySelector('.vogue-vibes');
const phrases = [
  "IT IS VOGUE VIBES",
  "IT IS VIBES IT VOGUE",
  "VOGUE IT IS VIBES",
  "VIBES VOGUE IT IS",
  "IT`S VIBES VOGUE",
  "VOGUE & VIBES IT IS"
];

// Get all elements with the class "option"
var options = document.querySelectorAll(".option");

// Add click event handler to each option
options.forEach(function(option) {
  option.addEventListener("click", function() {
    // Remove "active" class from all options
    options.forEach(function(option) {
      option.classList.remove("active");
    });

    // Add "active" class to the selected option
    this.classList.add("active");
  });
});

// Function to update the logo source based on the current page
function updateLogoSrc() {
  if (isAboutUs() || isHelp()) {
    const logo = document.querySelector('.icons img');
    const logonav = document.querySelector('.logo img');
    if (logonav) logonav.setAttribute("src", "../img/workpieces/blackMask.png");
    if (logo) logo.setAttribute("src", "../img/workpieces/blackMask.png");
  }
}

// Function to update the display style of the navbar and menu
function updateNavbarDisplay() {
  if (isHomePage()) {
    navbar.classList.add('hidden');
    menu.classList.add('hidden');

    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 0) {
        navbar.classList.add('active');
        navbar.classList.remove('hidden');
        menu.classList.add('active');
        menu.classList.remove('hidden');
      } else {
        navbar.classList.remove('active');
        navbar.classList.add('hidden');
        menu.classList.remove('active');
        menu.classList.add('hidden');
      }
    });
  } else {
    navbar.classList.add('active');
    if (isAboutUs() || isHelp()) {
      menu.classList.add('hidden');
    } else {
      menu.classList.add('active');
    }
  }
}

// Function to manage the display of the catalog menu
function setupCatalogMenu() {
  catalogBtn.addEventListener('click', () => {
    if (isCatalogMenuOpen) {
      catalogMenu.style.display = 'none';
      isCatalogMenuOpen = false;
    } else {
      catalogMenu.style.display = 'block';
      isCatalogMenuOpen = true;
    }
  });

  catalogBtn.addEventListener('touchstart', (event) => {
    event.preventDefault(); // Prevent the default click action
    if (isCatalogMenuOpen) {
      catalogMenu.style.display = 'none';
      isCatalogMenuOpen = false;
    } else {
      catalogMenu.style.display = 'block';
      isCatalogMenuOpen = true;
    }
  });

  if (catalogMenu) {
    catalogMenu.addEventListener('mousemove', () => {
      isCatalogMenuOpen = true;
    });

    catalogMenu.addEventListener('mouseleave', () => {
      isCatalogMenuOpen = false;
      catalogMenu.style.display = 'none';
    });
  }

  window.addEventListener('mousemove', (event) => {
    if (catalogMenu && !catalogMenu.contains(event.target)) {
      isCatalogMenuOpen = false;
    }
  });
}

// Call functions when the page loads
window.addEventListener('load', () => {
  updateNavbarDisplay();
  updateLogoSrc();
  setupCatalogMenu();
});

// Function to handle color selection
function handleColorSelection() {
  let circle = document.querySelector(".color-option");
  if (circle) {
    circle.addEventListener("click", (e) => {
      let target = e.target;
      if (target.classList.contains("circle")) {
        let activeCircle = circle.querySelector(".active");
        if (activeCircle) activeCircle.classList.remove("active");
        target.classList.add("active");
        let activeImage = document.querySelector(".main-images .active");
        if (activeImage) activeImage.classList.remove("active");
        document.querySelector(`.main-images .${target.id}`).classList.add("active");
      }
    });
  }
}

window.addEventListener("load", handleColorSelection);

// Function to set up the content slider
function setupContentSlider() {
  const navItems = document.querySelectorAll('.nav-item');
  const contentItems = document.querySelectorAll('.content-item');

  function setActiveContent(contentId) {
    // Remove 'active' class from all navigation and content items
    navItems.forEach(function(item) {
      item.classList.remove('active');
    });
    contentItems.forEach(function(item) {
      item.classList.remove('active');
    });

    // Add 'active' class to the selected navigation and content items
    const selectedNavItem = document.querySelector('.nav-item[data-content="' + contentId + '"]');
    const selectedContentItem = document.querySelector('.content-item[data-content="' + contentId + '"]');

    if (selectedNavItem && selectedContentItem) {
      selectedNavItem.classList.add('active');
      selectedContentItem.classList.add('active');
    }
  }

  navItems.forEach(function(navItem) {
    navItem.addEventListener('click', function() {
      const contentId = this.getAttribute('data-content');
      setActiveContent(contentId);
    });
  });
}

document.addEventListener('DOMContentLoaded', setupContentSlider);

// Function to select a random color that is different from the previous one
function getRandomColor(previousColor) {
  const colors = ["#000000", "#FFFFFF", "#9747FF80"];
  let randomIndex = Math.floor(Math.random() * colors.length);
  let color = colors[randomIndex];

  while (color === previousColor) {
    randomIndex = Math.floor(Math.random() * colors.length);
    color = colors[randomIndex];
  }

  return color;
}

window.addEventListener('load', () => {
  let previousColor = null; // Store the color of the previous line
  const usedPhrases = []; // Store used phrases

  for (let i = 0; i < 6; i++) {
    let phrase = phrases[Math.floor(Math.random() * phrases.length)];

    // Check if the phrase has already been used
    while (usedPhrases.includes(phrase)) {
      phrase = phrases[Math.floor(Math.random() * phrases.length)];
    }

    usedPhrases.push(phrase); // Add phrase to the list of used phrases

    const words = phrase.split(' ');

    const h1 = document.createElement('h1');
    h1.style.left = Math.random() * 100 + '%';
    h1.style.top = Math.random() * 100 + '%';
    h1.style.display = 'inline-block';

    const firstColor = getRandomColor(previousColor);
    const secondColor = getRandomColor(firstColor);

    words.forEach((word, index) => {
      if (index > 0) {
        const space = document.createElement('span');
        space.textContent = ' ';
        space.style.marginRight = Math.random() * 40 + 'px';
        h1.appendChild(space);
      }

      const span = document.createElement('span');
      span.textContent = word;

      if (index === 1 || index === 2) {
        span.style.color = firstColor;
      } else {
        span.style.color = secondColor;
      }

      h1.appendChild(span);
    });

    if (vogueVibes) {
      vogueVibes.appendChild(h1);
    }
    previousColor = secondColor;
  }
});

// Function to toggle dropdown visibility
function toggleDropdown(btn) {
  btn.classList.toggle('active');
  var dropdownContent = btn.nextElementSibling;
  dropdownContent.classList.toggle('active');
}

var coll = document.getElementsByClassName("collapsible");

// Add event listener to each collapsible element
for (var i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle('active');
    var content = this.nextElementSibling;

    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
