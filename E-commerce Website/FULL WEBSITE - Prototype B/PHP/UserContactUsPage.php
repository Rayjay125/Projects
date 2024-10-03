<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>

<body>
    <!--Navigation-->
    <?php 
        include "UserNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/ContactUsPageTemplate.php";
    ?>


</body>
</html>