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
    <script src="../JavaScript/LoadHTML.js"></script>
    <nav class="navbar"><div id="navbar-placeholder"></div></nav>
    <script> loadHTML('../HTML/NavigationBar.html', 'navbar-placeholder'); </script>

    <!--Include page template-->
    <?php 
        $_SESSION['redirectToHomePage'] = "<script> location.replace('../HTML/HomePage.html'); </script>";
        include "../PHPTemplates/CheckoutTemplate.php";
    ?>
</body>
</html>