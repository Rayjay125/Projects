<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../CSS/RegistrationPageStyles.css">
</head>

<body>
    <!--Navigation-->
    <script src="../JavaScript/LoadHTML.js"></script>
    <nav class="navbar"><div id="navbar-placeholder"></div></nav>
    <script> loadHTML('../HTML/NavigationBar.html', 'navbar-placeholder'); </script>

    <!--Registration form-->
    <div class="registration-form-container">
        <h2>Register for an Account</h2>
        <form id="registrationForm" action = "RegistrationPage.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" placeholder = "Optional">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <button type="submit" id="register" name="register">Register</button>
        </form>

        <div id="errorMessage" class="errorMessage"></div>
    </div>


    <?php
        // Prepare the SQL statement
        
        $sql = "INSERT INTO persons (Username, Password, Address, ID, Email, PhoneNumber, AccountType) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $sql2 = "INSERT INTO persons (Username, Password, Address, Email, PhoneNumber, AccountType) VALUES (?, ?, ?, ?, ?, ?)";
        $sql3 = "SELECT Username, Email FROM persons WHERE username = ? OR email = ?";

        $stmt = $conn->prepare($sql);
        $stmt2 = $conn->prepare($sql2);
        $stmt3 = $conn->prepare($sql3);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($stmt2 === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($stmt3 === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Check if username is unique
        if (isset($_POST['register'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $stmt3->bind_param("ss", $username, $email);

            // Execute the select statement
            if ($stmt3->execute()) {
                // Bind result to variables
                $stmt3->bind_result($dbUsername, $dbEmail);
                $stmt3->fetch();

                if ($dbUsername || $dbEmail) {
                    // Username exists in database
                    echo "<script> alert('Username or Email is taken!'); </script>";
                } else {
                    // Username is available, register user
                    // If user doesn't enter an ID number
                    if ($_POST['id']===""){
                        // Bind parameters
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash password for extra security
                        $address = $_POST['address'];
                        $email = $_POST['email']; 
                        $phone = $_POST['phone'];
                        $accountType = "user";

                        $stmt2->bind_param("ssssss", $username, $password, $address, $email, $phone, $accountType);

                        // Execute the statement
                        if ($stmt2->execute()) {
                            echo "<script> alert('User registered successfully!'); </script>";
                        } else {
                            echo "<script> alert('Error registering user: ') </script>;";
                            echo "Error registering user: " . $stmt2->error;
                        }
                    } else { // User has entered an ID number
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash password for extra security
                        $address = $_POST['address'];
                        $ID = $_POST['id']; 
                        $email = $_POST['email']; 
                        $phone = $_POST['phone'];
                        $accountType = "user";

                        $stmt->bind_param("sssssss", $username, $password, $address, $ID, $email, $phone, $accountType);

                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script> alert('User registered successfully!'); </script>";
                        } else {
                            echo "<script> alert('Error registering user: ') </script>;";
                            echo "Error registering user: " . $stmt->error;
                        }
                    }
                    
                }
            }
        }

        // Close statement
        $stmt->close();
        $stmt2->close();
        $stmt3->close();
    ?>
</body>
</html>