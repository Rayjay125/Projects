function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var address = document.getElementById("address").value;
    var id = document.getElementById("id").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;
    errorMessage.innerHTML = "";

    /*
    // Simple validation - just checking if fields are not empty
    if (username === "" || password === "" || address === "" || id === "" || email === "" || phone === "") {
        errorMessage.innerHTML += "Please fill in all fields.";
        return false;
    }

    // if the length of the id is not 12
    if (id.length() !== 12){
        errorMessage.innerHTML += "\nInvalid ID";
    }

    // if the length of the phone number is not 10
    if (phone.length() > 13){
        errorMessage.innerHTML += "\nInvalid Phone Number";
    }

    // email is validated by the html input tag

    //If there is a space in the username or password
    if(Username.contains(" ") || (Password.contains(" "))){
        errorMessage.innerHTML += "There should be no space in the Username or Password";
        return false;
    }   

    //If password is not 8 characters long
    If (Password.length() < 8){
        errorMessage.innerHTML += "\nPassword should be at least 8 characters long";
    }


    //Check if username is unique


    /* // if there is invalid input
    if (alert !== "") {
        alert(alert);
        return false;
    } else {
        insertUserIntoDB();
    } */


    //function to activate hidden button that sends user data to second php script
    function activateButton() {
        document.getElementById("hiddenButton").click();
    }


    return true;
}