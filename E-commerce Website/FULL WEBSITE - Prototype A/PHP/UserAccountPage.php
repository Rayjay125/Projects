<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="../CSS/RegistrationPageStyles.css">
    
</head>

<body>
    <!--Navigation-->
    <?php 
        include "UserNavigationBar.php";
    ?>

    <!-- php code to fetch the user's info -->
    <?php
        $_SESSION['accountRedirectStatement'] = "<script> location.replace('../PHP/UserAccountPage.php'); </script>";
        include "../PHPTemplates/AccountPageTemplate.php";
    ?>

</body>
</html>