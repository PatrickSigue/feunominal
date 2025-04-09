document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");
  const openModalBtn = document.getElementById("openModal");
  const wrapper = modal.querySelector(".wrapper");

  // Open modal
  openModalBtn.addEventListener("click", function (e) {
    e.preventDefault();
    modal.style.display = "flex";
  });

  // Close modal when clicking outside the .wrapper
  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});

const loginText = document.querySelector(".title-text .login");
     const loginForm = document.querySelector("form.login");
     const loginBtn = document.querySelector("label.login");
     const signupBtn = document.querySelector("label.signup");
     const signupLink = document.querySelector("form .signup-link a");
     signupBtn.onclick = (()=>{
       loginForm.style.marginLeft = "-50%";
       loginText.style.marginLeft = "-50%";
     });
     loginBtn.onclick = (()=>{
       loginForm.style.marginLeft = "0%";
       loginText.style.marginLeft = "0%";
     });
     signupLink.onclick = (()=>{
       signupBtn.click();
       return false;
     });