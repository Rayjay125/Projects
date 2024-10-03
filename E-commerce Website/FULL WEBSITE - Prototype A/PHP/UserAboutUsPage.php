<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
</head>

<body>
    <!--Navigation-->
    <?php 
        include "UserNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/AboutUsPageTemplate.php";
    ?>
</body>
</html>