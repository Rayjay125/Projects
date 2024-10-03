//Function to toggle passord visibility

function togglePasswordVisibility(passwordInputId, toggleButtonId) {
    var passwordInput = document.getElementById(passwordInputId);
    var toggleButton = document.getElementById(toggleButtonId);
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleButton.textContent = "Hide";
    } else {
        passwordInput.type = "password";
        toggleButton.textContent = "Show";
    }
}

/*
<style>
.password-container {
    position: relative;
}
.password-toggle {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>
*/
