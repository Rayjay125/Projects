<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/LoginStyles.css">
</head>

<body>
    <!--Navigation-->
    <script src="../JavaScript/LoadHTML.js"></script>
    <nav class="navbar"><div id="navbar-placeholder"></div></nav>
    <script> loadHTML('../HTML/NavigationBar.html', 'navbar-placeholder'); </script>

    
    <!-- Login Form -->
    <div class="page-container">
        <div class="login-container">
            <h1> Login </h1>
            
            <form id="loginForm" action = "LoginPage.php" method = "POST">
                <label for="Username"> Username </label><br>
                <input type="text" id="username" name="username" required><br>

                <label for="Password"> Password </label><br>
                <input type="password" id="password" name="password" required><br>

                <input type="submit" value="login" id = "login" name ="login"><br>
            </form>

            <div id="errorMessage" class="errorMessage"></div>
        </div>
    </div>


    <?php
        // Prepare the SQL statement
        $sql = "SELECT UserID, Username, Password, AccountType FROM persons WHERE username = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        //When the Login button is clicked
        if (isset($_POST['login'])){
            // Bind parameters
            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt->bind_param("s", $username);

            // Execute the statement
            if ($stmt->execute()) {
                // Bind result to variables
                $stmt->bind_result($dbUserID, $dbUsername, $dbPassword, $dbAccountType);
                $stmt->fetch();

                if ($dbUsername) {
                    if (password_verify($password, $dbPassword)) {
                        // Passwords match, user authenticated
                        echo "<script> alert('Login successful!'); </script>";
                        
                        // Store userID, username and accountType in a session and transfer to home page
                        $_SESSION['userID'] = $dbUserID;
                        $_SESSION['username'] = $dbUsername;
                        $_SESSION['accountType'] = $dbAccountType;
                        if ($dbAccountType === "user"){
                            header("Location: ../PHP/UserHomePage.php");
                        } elseif ($dbAccountType === "admin"){
                            header("Location: ../PHP/AdminHomePage.php");
                        }
                        

                    } else {
                        // Passwords don't match
                        echo "<script> alert('Incorrect password!'); </script>";
                    }
                } else {
                    // Username not found
                    echo "<script> alert('Username not found!'); </script>";
                }
            } else {
                // Error executing statement
                echo "Error: " . $stmt->error;
            }
        }

        // Close statement
        $stmt->close();
    ?>
    
</body>
</html>