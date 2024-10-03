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
    <link rel="stylesheet" href="../CSS/ProductStyles.css">
</head>

<body>
    <!--Navigation-->
    <script src="../JavaScript/LoadHTML.js"></script>
    <nav class="navbar"><div id="navbar-placeholder"></div></nav>
    <script> loadHTML('../HTML/NavigationBar.html', 'navbar-placeholder'); </script>

    <!--Include page template-->
    <?php 
        include "../PHPTemplates/ProductCatalogueTemplate.php";
    ?>
</body>
</html>