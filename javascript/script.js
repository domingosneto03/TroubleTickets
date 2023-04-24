function validateUsername() {
    let username = document.getElementById("username").value;
    let usernameError = document.getElementById("usernameError");
    let valid = /^[a-zA-Z][a-zA-Z0-9]*$/.test(username);
    if (valid) {
        usernameError.textContent = "";
    } else {
        usernameError.textContent = "Username must start with a letter and contain only letters and numbers";
    }
}

function validatePassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let passwordError = document.getElementById("passwordError");
    let confirmPasswordError = document.getElementById("confirmPasswordError");

    if (password.length >= 8) {
        passwordError.textContent = "";
    } else {
        passwordError.textContent = "Password must be at least 8 characters long";
    }

    if (confirmPassword === password) {
        confirmPasswordError.textContent = "";
    } else {
        confirmPasswordError.textContent = "Passwords do not match";
    }
}

document.getElementById("username").addEventListener("input", validateUsername);
document.getElementById("password").addEventListener("input", validatePassword);
document.getElementById("confirmPassword").addEventListener("input", validatePassword);