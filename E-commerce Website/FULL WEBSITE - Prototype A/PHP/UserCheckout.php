<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>
    <!--Navigation-->
    <?php 
        include "UserNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        $_SESSION['redirectToHomePage'] = "<script> location.replace('../PHP/AdminHomePage.php'); </script>";
        include "../PHPTemplates/CheckoutTemplate.php";
    ?>
</body>
</html>