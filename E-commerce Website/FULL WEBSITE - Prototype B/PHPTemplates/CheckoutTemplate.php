<link rel="stylesheet" href="../CSS/AccountPageStyles.css">

<?php
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }
    // Make this particular file look blank, but not the pages where it is included
    /*if (basename($_SERVER['PHP_SELF']) == 'CheckoutTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }*/

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
        <input type="number" id="card_number" name="card_number" required><br><br>
        
        <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" id="expiry_date" name="expiry_date" required><br><br>
        
        <label for="cvv">CVV:</label>
        <input type="number" id="cvv" name="cvv" required><br><br>
        
        <button type="submit" id="paymentSubmission" name="paymentSubmission">Submit Payment</button>
    </form>
</div>



<?php
    // When form is submitted
    if (isset($_POST["paymentSubmission"])) {
        // Get the form data
        $name = $_POST['name'];
        $cardNumber = $_POST['card_number'];
        $expiryDate = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];

        // CONNECTION TO A SECURE PAYMENT GATEWAY WILL BE INSERTED HERE WHEN WEBSITE IS FULLY FUNCTIONAL

        // Get the total price and items from the cart session
        $totalPrice = 0.0;
        $items = $_SESSION['cart'];
        foreach ($items as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Prepare the order data
        if ($_SESSION['userID']){
            $client = $_SESSION['userID'];
        } else {
            $client = $name;
        }
        $orderDate = date('Y-m-d H:i:s');
        
        // Prepared Insert tatements
        $sql = "INSERT INTO orders (userID, total, orderDate) VALUES (?, ?, ?)";
        $sql2 = "SELECT max(OrderID) FROM `orders` where userID = ?";
        $sql3 = "INSERT INTO orderline (orderID, productID, quantity, total, orderDate) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt2 = $conn->prepare($sql2);
        $stmt3 = $conn->prepare($sql3);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($stmt2 === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($stmt3 === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("dds", $client, $totalPrice, $orderDate);  //ids

        if ($stmt->execute()) {
            // Get orderID
            $stmt2->bind_param("d", $client);

            if ($stmt2->execute()) {
                // Bind result to variables
                $stmt2->bind_result($dbOrderID);
                $stmt2->fetch();
                
                //FOR TROUBLESHOOTING
                //echo "orderID: ".$dbOrderID; 
                
                // Save needed variables
                $OrderID = $dbOrderID;

                // Close unneeded queries
                $stmt->close();
                $stmt2->close();

                // Prepare orderline data
                foreach ($items as $item) {
                    $productID = $item['productID'];
                    $quantity = $item['quantity'];
                    $subtotalPrice = 0.0;
                    $subtotalPrice += $item['price'] * $quantity;

                    // Execute orderline insert prepared statement
                    $stmt3->bind_param("dddds", $dbOrderID, $productID, $quantity, $subtotalPrice, $orderDate);
                    if (!($stmt3->execute())) {
                        // Error occurred
                        echo "Error: " . $stmt3->error;
                    }
                }

                // Order successfully saved
                echo "<script> alert('Order placed successfully!'); </script>";
                echo $_SESSION['redirectToHomePage'];
                // Clear the cart
                $_SESSION['cart'] = array();
            } else {
                // Error occurred
                echo "Error: " . $stmt2->error;
            }
        } else {
            // Error occurred
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        
        $stmt3->close();
    }
?>

