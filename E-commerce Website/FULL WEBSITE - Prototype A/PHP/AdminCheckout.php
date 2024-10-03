<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Checkout</title>
</head>
<body>
    <!--Navigation-->
    <?php 
        include "AdminNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        $_SESSION['redirectToHomePage'] = "<script> location.replace('../PHP/AdminHomePage.php'); </script>";
        include "../PHPTemplates/CheckoutTemplate.php";
    ?>
</body>
</html>