<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>About Us</title>
</head>
<body>
    <!--Navigation-->
    <?php 
        include "AdminNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/AboutUsPageTemplate.php";
    ?>
</body>
</html>