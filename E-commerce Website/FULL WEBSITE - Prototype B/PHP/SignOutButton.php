<?php
    if(isset($_POST['signout'])){
        echo "<script> alert('Logging out') </script>;";

        // Conditionally start session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Unset all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to generic home page
        echo "<script> location.replace('../HTML/HomePage.html'); </script>";
    }
?>


