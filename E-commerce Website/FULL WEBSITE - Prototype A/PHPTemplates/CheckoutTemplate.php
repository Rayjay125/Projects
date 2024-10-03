<link rel="stylesheet" href="../CSS/AccountPageStyles.css">

<?php
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }
    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'CheckoutTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }

    // Check if the cart is empty, and exit page if the card is empty
    if (empty($_SESSION['cart'])) {
        echo "<script> alert('Cart is empty!'); </script>";
        echo "<script> location.replace('{$_SERVER['HTTP_REFERER']}'); </script>"; // Go to previous page
    }
?>


<div class="form-container">
    <h1>Checkout</h1>
    <form action="../PHPTemplates/CheckoutTemplate.php" method="post">
        <h2>Payment Details</h2>
        <label for="name">Name on Card:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required><br><br>
        
        <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" id="expiry_date" name="expiry_date" required><br><br>
        
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required><br><br>
        
        <button type="submit" id="paymentSubmission" name="paymentSubmission">Submit Payment</button>
    </form>
</div>

<?php
    // When form is submitted
    if (isset($_POST["paymentSubmission"])) {
        // Get the form data
        $name = $_POST['name'];
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];

        // CONNECTION TO A SECURE PAYMENT GATEWAY WILL BE INSERTED HERE WHEN WEBSITE IS FULLY FUNCTIONAL

        // Get the total price and items from the cart session
        $total_price = 0.0;
        $items = $_SESSION['cart'];
        foreach ($items as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }


        // Prepare remaining order data
        $userID = $_SESSION['UserID'];
        $orderDate = date('Y-m-d H:i:s');

        // Encode the cart items into JSON format for database readability
        $items = json_encode($items);
        
        // Prepared Insert order statement
        $sql = "INSERT INTO orders (UserID, items, total, orderDate) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssds", $userID, $items, $totalPrice, $orderDate);

        if ($stmt->execute()) {
            // Order successfully saved
            echo "<script> alert('Order placed successfully!'); </script>";
            echo $_SESSION['redirectToHomePage'];
            // Clear the cart
            $_SESSION['cart'] = array();
        } else {
            // Error occurred
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
    }
?>

