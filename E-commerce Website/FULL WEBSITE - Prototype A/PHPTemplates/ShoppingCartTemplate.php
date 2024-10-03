<link rel="stylesheet" href="../CSS/ShoppingCartStyles.css">  

<?php
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }
    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'ShoppingCartTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }

    // Conditionally initialize cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Initialize total items and total price
    $total_items = 0;
    $total_price = 0.0;

    // Loop through the cart to calculate total items and total price
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
        $total_price += $item['price'] * $item['quantity'];
    }

    // Format total price to 2 decimal places
    $total_price = number_format($total_price, 2);
?>

<!-- Display Shopping Cart -->
<div class="shopping-cart-container">
    <h2>Shopping Cart</h2> 
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty</p>
    <?php else: ?>
        <table id="cartItems">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>R<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>R<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <div>
                <p><strong>Total Items:</strong> <?php echo $total_items; ?></p>
                <p><strong>Total Price:</strong> R<?php echo $total_price; ?></p>
            </div>
            <div style="position: right; padding: 20px">
                <form action="../PHPTemplates/ShoppingCartTemplate.php" method="POST">
                    <input class="cartButton" type="submit" id="clear" name="clear" value="Clear cart">
                    <input class="cartButton" type="submit" id="checkout" name="checkout" value="Checkout">
                </form>
            </div>
        </div>
        
    <?php endif; 

    // Clear cart functionality
    if (isset($_POST['clear'])){
        $_SESSION['cart'] = array();
        echo "<script> alert('Cart cleared!'); </script>";
        echo "<script> location.replace('{$_SERVER['HTTP_REFERER']}'); </script>"; // Go to previous page
    }

    // Checkout functionality
    if (isset($_POST['checkout'])){
        if ($_SESSION['accountType'] === "user"){
            echo "<script> alert('Redirecting to user checkout!'); </script>";
            echo "<script> location.replace('../PHP/UserCheckout.php'); </script>";
        } elseif ($_SESSION['accountType'] === "admin"){
            echo "<script> alert('Redirecting to admin checkout!'); </script>";
            echo "<script> location.replace('../PHP/AdminCheckout.php'); </script>";
        } elseif (!($_SESSION['accountType'])){
            echo "<script> alert('Redirecting to checkout!'); </script>";
            echo "<script> location.replace('../PHP/Checkout.php'); </script>";
        }
    }
    ?>
</div>
