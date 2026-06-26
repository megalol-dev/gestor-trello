const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const confirmInput = document.getElementById("password_confirmation");

const nameMsg = document.getElementById("name-message");
const emailMsg = document.getElementById("email-message");
const passwordMsg = document.getElementById("password-message");
const confirmMsg = document.getElementById("confirm-message");
const forbiddenChars = /['"<>\;]/;

const registerBtn = document.getElementById("register-btn");

if (
    !nameInput ||
    !emailInput ||
    !passwordInput ||
    !confirmInput ||
    !registerBtn
) {
    // No estamos en la página de registro
} else {
    const forbiddenChars = /['"<>\;]/;

    function validateForm() {
        const validName = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,}$/.test(nameInput.value);

        const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);

        const validPassword = passwordInput.value.length >= 8;

        const validConfirm =
            passwordInput.value === confirmInput.value &&
            confirmInput.value.length > 0;

        registerBtn.disabled = !(
            validName &&
            validEmail &&
            validPassword &&
            validConfirm
        );
    }

    function validateName() {
        if (forbiddenChars.test(nameInput.value)) {
            nameMsg.textContent = "Caracteres no permitidos.";

            nameMsg.className = "validation-message invalid";

            return;
        }

        if (/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,}$/.test(nameInput.value)) {
            nameMsg.textContent = "Nombre válido.";

            nameMsg.className = "validation-message valid";
        } else {
            nameMsg.textContent = "Mínimo 3 letras. Solo letras.";

            nameMsg.className = "validation-message invalid";
        }

        validateForm();
    }

    function validateEmail() {
        if (forbiddenChars.test(emailInput.value)) {
            emailMsg.textContent = "Caracteres no permitidos.";

            emailMsg.className = "validation-message invalid";

            return;
        }

        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
            emailMsg.textContent = "Correo válido.";

            emailMsg.className = "validation-message valid";
        } else {
            emailMsg.textContent = "Correo no válido.";

            emailMsg.className = "validation-message invalid";
        }

        validateForm();
    }

    function validatePassword() {
        if (forbiddenChars.test(passwordInput.value)) {
            passwordMsg.textContent = "Caracteres no permitidos.";

            passwordMsg.className = "validation-message invalid";

            return;
        }

        if (passwordInput.value.length >= 8) {
            passwordMsg.textContent = "Contraseña válida.";

            passwordMsg.className = "validation-message valid";
        } else {
            passwordMsg.textContent = "Mínimo 8 caracteres.";

            passwordMsg.className = "validation-message invalid";
        }

        validateConfirm();
        validateForm();
    }

    function validateConfirm() {
        if (
            passwordInput.value === confirmInput.value &&
            confirmInput.value.length > 0
        ) {
            confirmMsg.textContent = "Las contraseñas coinciden.";

            confirmMsg.className = "validation-message valid";
        } else {
            confirmMsg.textContent = "Las contraseñas no coinciden.";

            confirmMsg.className = "validation-message invalid";
        }

        validateForm();
    }

    nameInput.addEventListener("input", validateName);
    emailInput.addEventListener("input", validateEmail);
    passwordInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validateConfirm);
}