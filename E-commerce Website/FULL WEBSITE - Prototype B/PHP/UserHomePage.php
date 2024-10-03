<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../CSS/HomeStyles.css">
</head>

<body>
    <!--Navigation-->
    <?php 
        include "SignOutButton.php";
    ?>

    <link rel="stylesheet" href="../CSS/NavigationStyles.css">
    <link rel="stylesheet" href="../CSS/SignOutButton.css">

    <!--User Navigation Bar-->
    <nav class="navbar">
        <div class="container">
            <h1 class="logo">Reed Shoe Emporium</h1>
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="../PHP/UserHomePage.php">Home</a></li>
                    <li><a href="../PHP/UserProductCatalogue.php">Products</a></li>
                    <li><a href="../PHP/UserShoppingCart.php">Shopping Cart</a></li>
                    <li><a href="../PHP/UserAboutUsPage.php">About</a></li>
                    <li><a href="../PHP/UserContactUsPage.php">Contact</a></li>
                    <li><a href="../PHP/UserAccountPage.php">My Account</a></li>
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