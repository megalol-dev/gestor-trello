const form = document.querySelector(".auth-container form");
const loginBtn = document.getElementById("login-btn");

if (form && loginBtn) {
    form.addEventListener("submit", () => {
        loginBtn.textContent = "Iniciando sesión...";
        loginBtn.disabled = true;
    });
}
