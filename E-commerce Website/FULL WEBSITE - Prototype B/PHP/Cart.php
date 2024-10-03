<?php
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'AboutUsPageTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }

    // Initialize the shopping cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }


    // Get the product details from the form
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
    $product_price = filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

    // Validate the input
    if ($product_id && $product_name && $product_price && $quantity) {
        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Update the quantity if the product is already in the cart
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            //For troubleshooting - print cart
            /*
            echo '<br/><br/><br/><br/><br/><br/>';          
            print_r($_SESSION['cart']);
            */
            echo "<script> alert('Item(s) quantity updated in cart!'); </script>";
        } else {
            // Add the product to the cart with its details
            $_SESSION['cart'][$product_id] = [
                'productID' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity
            ];
            //For troubleshooting - print cart
            /*
            echo '<br/><br/><br/><br/><br/><br/>';          
            print_r($_SESSION['cart']);
            */
            echo "<script> alert('Item(s) added to cart!'); </script>";
        }
    }

    // Redirect to previous page
    echo "<script> location.replace('{$_SERVER['HTTP_REFERER']}'); </script>";
?>