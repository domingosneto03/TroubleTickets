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

function expandImage(element) {
    var src = element.getAttribute('src');
    document.getElementById('expandedImage').setAttribute('src', src);
    document.getElementById('imageOverlay').style.display = 'block';

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageOverlay();
        } 
    });
}

function closeImageOverlay() {
    document.getElementById('imageOverlay').style.display = 'none';
}

var elements = document.getElementsByClassName("ticket_image");
for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', function () {
        expandImage(this);
    });
}
document.getElementById('closeButton').addEventListener('click', closeImageOverlay);

/*
document.getElementById("username").addEventListener("input", validateUsername);
document.getElementById("password").addEventListener("input", validatePassword);
document.getElementById("confirmPassword").addEventListener("input", validatePassword);*/