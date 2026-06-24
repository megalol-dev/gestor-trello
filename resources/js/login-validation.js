const form = document.querySelector("form");
const loginBtn = document.getElementById("login-btn");

form.addEventListener("submit", () => {
    loginBtn.textContent = "Iniciando sesión...";
    loginBtn.disabled = true;
});
