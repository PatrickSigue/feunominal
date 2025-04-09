// search-box open close js code
let navbar = document.querySelector(".navbar");
let searchBox = document.querySelector(".search-box .bx-search");
// let searchBoxCancel = document.querySelector(".search-box .bx-x");
searchBox.addEventListener("click", ()=>{
  navbar.classList.toggle("showInput");
  if(navbar.classList.contains("showInput")){
    searchBox.classList.replace("bx-search" ,"bx-x");
  }else {
    searchBox.classList.replace("bx-x" ,"bx-search");
  }
});
// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");
menuOpenBtn.onclick = function() {
navLinks.style.left = "0";
}
menuCloseBtn.onclick = function() {
navLinks.style.left = "-100%";
}
// sidebar submenu open close js code
let htmlcssArrow = document.querySelector(".htmlcss-arrow");
htmlcssArrow.onclick = function() {
 navLinks.classList.toggle("show1");
}
let moreArrow = document.querySelector(".more-arrow");
moreArrow.onclick = function() {
 navLinks.classList.toggle("show2");
}
let jsArrow = document.querySelector(".js-arrow");
jsArrow.onclick = function() {
 navLinks.classList.toggle("show3");
}

// Get modal element
const modal = document.getElementById("modal");

// Get open modal anchor
const openModalLink = document.getElementById("openModal");

// Get close button
const closeButton = document.querySelector(".close-button");

// Listen for open click
openModalLink.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default anchor click behavior
    modal.style.display = "block"; // Show the modal
});

// Listen for close click
closeButton.addEventListener("click", () => {
    modal.style.display = "none"; // Hide the modal
});

// Listen for outside click
window.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.style.display = "none"; // Hide the modal if clicked outside
    }
});