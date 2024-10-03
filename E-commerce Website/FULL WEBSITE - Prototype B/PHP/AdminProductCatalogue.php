<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <!--Navigation-->
    <?php 
        include "AdminNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/ProductCatalogueTemplate.php";
    ?>
</body>
</html>