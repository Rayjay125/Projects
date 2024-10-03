<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";

    //Remove unnecessary warnings
    error_reporting(E_ALL & ~E_NOTICE); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="../CSS/AccountPageStyles.css">
</head>
<body>
    <!--Navigation-->
    <?php 
        include "AdminNavigationBar.php";
    ?>


    <!--Database product management form-->
    <div class="form-container">
        <form id="updateForm" autocomplete="off" action = "AdminProductManagement.php" method = "POST">
            <!--Input to disable autocompletion by the browser-->    
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            
            <h2>Search Product</h2>
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="searchName" name="searchName" required>
            </div>
            <div>
                <button type="submit" id = "search" name = "search">Search</button><br><br>
            </div>
        </form>
    </div>

    <div class="form-container">
        <form id="updateForm" autocomplete="off"  action = "AdminProductManagement.php" method = "POST">
            <!--Input to disable autocompletion by the browser-->    
            <input autocomplete="false" name="hidden" type="text" style="display:none;">

            <!-- The rest of the form -->
            <h2>Manage Product</h2>
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Product Category:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="description">Product Description:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="imgFilename">Product Image Filename:</label>
                <input type="text" id="imgFilename" name="imgFilename" required>
                <!--Display Product image-->
                <div class="image-container">
                    <img class="image-box" id="image">
                </div>
            </div>
            <div> 
                <button type="submit" id = "update" name = "update">Update</button><br><br>
                <button type="submit" id = "insert" name = "insert">Insert</button><br><br>
                <button type="submit" id = "delete" name = "delete">Delete</button><br><br>
            </div>
    </div>



    <!-- PHP code to search for product -->
    <?php
        // Prepare the SQL statements
        $sql = "SELECT Name,Category,Price,Description,Filename FROM Products WHERE Name = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // When the Search button is clicked
        if (isset($_POST['search'])){

            // Bind parameters
            $productName = $_POST['searchName'];
            $stmt->bind_param("s", $productName);

            // Execute the select statement
            if ($stmt->execute()) {
                // Bind result to variables
                $stmt->bind_result($dbName, $dbCategory, $dbPrice, $dbDescription, $dbFilename);
                $stmt->fetch();

                if (!($dbPrice)){
                    echo "<script> alert('Product is not in database!'); </script>";
                } else {
                    echo "<script>document.getElementById('name').value = '" . htmlspecialchars($dbName) . "';</script>";
                    echo "<script>document.getElementById('category').value = '" . htmlspecialchars($dbCategory) . "';</script>";
                    echo "<script>document.getElementById('price').value = '" . htmlspecialchars($dbPrice) . "';</script>";
                    echo "<script>document.getElementById('description').value = '" . htmlspecialchars($dbDescription) . "';</script>";
                    echo "<script>document.getElementById('imgFilename').value = '" . htmlspecialchars($dbFilename) . "';</script>";
                    $imageLocation = "../Images/Products/" . $dbFilename;
                    echo "<script>document.getElementById('image').src = '" . htmlspecialchars($imageLocation) . "';</script>";
                }   
            }
        }

        // Close statement
        $stmt->close();
    ?>


    <!-- PHP code to update product info -->
    <?php 
        // Prepare the SQL statements
        $sql = "UPDATE Products SET Name = ?,Category = ?,Price = ?,Description = ?,Filename = ? WHERE Name = ? OR Filename = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        // When the Update button is clicked
        if (isset($_POST['update'])){
            $name = $_POST['name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $filename = $_POST['imgFilename'];

            // Bind parameters
            $stmt->bind_param("sssssss", $name,$category,$price,$description,$filename,$name,$filename);

            // Execute the update statement
            if ($stmt->execute()) {
                echo "<script> alert('Product updated successfully!'); </script>";
            } else {
                echo "<script> alert('Error updating product!') </script>;";
                echo "Error updating user info: " . $stmt->error;
            }
        }

        // Close statement
        $stmt->close();
    ?>

    <!-- PHP code to insert product into database -->
    <?php 
        // Prepare the SQL statement
        $sql = "INSERT INTO Products(Name,Category,Price,Description,Filename) Values(?,?,?,?,?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        // When the Insert button is clicked
        if (isset($_POST['insert'])){
            $name = $_POST['name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $filename = $_POST['imgFilename'];

            // Bind parameters
            $stmt->bind_param("sssss", $name,$category,$price,$description,$filename);

            // Execute the update statement
            if ($stmt->execute()) {
                echo "<script> alert('Product inserted successfully!'); </script>";
            } else {
                echo "<script> alert('Error inserting product!') </script>;";
                echo "Error updating user info: " . $stmt->error;
            }
        }

        // Close statement
        $stmt->close();
    ?>

    <!-- PHP code to delete product from database -->
    <?php 
        // Prepare the SQL statement
        $sql = "DELETE FROM Products WHERE Name = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        //When the Delete button is clicked
        if (isset($_POST['delete'])){
            $name = $_POST['name'];

            // Bind parameters
            $stmt->bind_param("s", $name);

            // Execute the update statement
            if ($stmt->execute()) {
                echo "<script> alert('Product deleted successfully!'); </script>";
            } else {
                echo "<script> alert('Error deleting product!') </script>;";
                echo "Error updating user info: " . $stmt->error;
            }
        }

        // Close statement
        $stmt->close();
    ?>

</body>
</html>