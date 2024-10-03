function updateInfo() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var address = document.getElementById("address").value;
    var id = document.getElementById("id").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;

    // Perform necessary updates here, e.g., send data to server

    // Display success message
    alert("Information updated successfully!");

    // Prevent form submission (you can redirect the user to another page if needed)
    return false;
}


//Important function to toggle passord visibility
/*
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("passwordInput");
    var passwordToggle = document.querySelector(".password-toggle");
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.textContent = "Hide";
    } else {
        passwordInput.type = "password";
        passwordToggle.textContent = "Show";
    }
}
*/
