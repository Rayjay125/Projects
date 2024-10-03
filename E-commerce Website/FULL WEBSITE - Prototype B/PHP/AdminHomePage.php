<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/HomeStyles.css">
</head>
<body>
    <!--Navigation-->
    <?php 
        include "SignOutButton.php";
    ?>

    <link rel="stylesheet" href="../CSS/NavigationStyles.css">
    <link rel="stylesheet" href="../CSS/SignOutButton.css">

    <!--Admin Navigation Bar-->
    <nav class="navbar">
        <div class="container">
            <h1 class="logo">Reed Shoe Emporium</h1>
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="../PHP/AdminHomePage.php">Home</a></li>
                    <li><a href="../PHP/AdminProductCatalogue.php">Products</a></li>
                    <li><a href="../PHP/AdminShoppingCart.php">Shopping Cart</a></li>
                    <li><a href="../PHP/AdminAboutUsPage.php">About</a></li>
                    <li><a href="../PHP/AdminContactUsPage.php">Contact</a></li>
                    <li><a href="../PHP/AdminAccountPage.php">My Account</a></li>
                    <li><a href="../PHP/AdminProductManagement.php">Product Manager</a></li>
                    <li><form action="SignOutButton.php" method="POST">
                            <input type="submit" value="Sign out" id = "signout" name ="signout">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/HomePageTemplate.php";
    ?>
</body>
</html>