<link rel="stylesheet" href="../CSS/ProductStyles.css">

<?php
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'ProductCatalogueTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }

    // Fetch all products
    $sql = "SELECT productId, name, description, price, category, filename FROM products";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    // Execute the select statement
    if ($stmt->execute()) {
        // Bind result
        $result = $stmt->get_result();
    }


    if ($result->num_rows > 0) {
        echo '<div class="container">';
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $product_id = $row['productId'];
            $product_name = $row['name'];
            $product_description = $row['description'];
            $product_price = $row['price'];
            $product_category = $row['category'];
            $product_filename = $row['filename'];
            ?>

            <!-- Display products -->
            <div class="product">
                <img src="<?php echo '../Images/Products/' . htmlspecialchars($product_filename); ?>">
                <div class="product-info">
                    <h2 class="product-title"><?php echo htmlspecialchars($product_name); ?></h2>
                    <p class="product-description"><?php echo htmlspecialchars($product_description); ?></p>
                    <p class="product-category"><?php echo htmlspecialchars($product_category); ?></p>
                    <p class="product-price">R<?php echo htmlspecialchars(number_format($product_price, 2)); ?></p>
                </div>
                <div class="quantiy">
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>"> <!-- Hidden inputs to pass product ID, name, price, and quantity -->
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
                        <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product_price); ?>">
                        <label for="quantity_<?php echo $product_id; ?>">Quantity:</label>
                        <input type="number" id="quantity_<?php echo $product_id; ?>" name="quantity" value="1" min="1" style="width: 50px;">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();

    // For troubleshooting - view items in cart
    /*
    if ($_SESSION['cart']) {
        print_r($_SESSION['cart']);
    } else {
        echo "there is no cart!";
    }
    */
?>

