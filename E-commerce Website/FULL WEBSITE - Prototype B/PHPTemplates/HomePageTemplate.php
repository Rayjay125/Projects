<?php 
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'HomePageTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }
?>

<link rel="stylesheet" href="../CSS/HomeStyles.css">

<div class="hero">
    <h1>Welcome to Reed's Shoe Emporium</h1>
</div>

<div class="features">
    <div class="feature">
        <img src="../Images/Feature1.jpg" alt="Feature 1">
        <h2>Browse Shoe Catalogue</h2>
        <p>Peruse our wide collection of stylish shoes</p>
    </div>
    <div class="feature">
        <img src="../Images/Feature2.png" alt="Feature 2">
        <h2>Shop Online</h2>
        <p>Add products to the shopping cart and buy online</p>
    </div>
    <div class="feature">
        <img src="../Images/Feature3.jpg" alt="Feature 3">
        <h2>Become A Member</h2>
        <p>Create an account and be updated on the latest and juiciest offers for members only</p>
    </div>
</div>

<footer>
    <p>&copy; <span id="currentYear"></span> Reed Shoe Emporium. All rights reserved.</p>
</footer>

<!-- JavaScript to update the current year at the footer -->
<script>
    document.getElementById('currentYear').innerText = new Date().getFullYear();
</script>
    