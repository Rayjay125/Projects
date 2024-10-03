<?php 
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'AboutUsPageTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }
?>

<link rel="stylesheet" href="../CSS/AboutUsStyles.css">
<div class="AboutUsContainer">
    <h1>About Us</h1>
    <h2>Mission Statement:</h2>
    <p>
        Offering a carefully chosen assortment of fashionable shoes that enable our clients to stride boldly into every moment is our objective at Reed's Shoe Emporium: to enrich the Cape Town footwear experience. In addition to celebrating individual style and offering a tailored and pleasurable shopping experience, we aim to combine comfort with style. Our objective is to become the preferred choice for shoe aficionados who value fine craftsmanship and distinctiveness, all while upholding a strong dedication to quality, local support, and classic beauty.
    </p>
    <h2>Company Values:</h2>
    <ul class="AboutUsList">
        <li><strong>Quality Craftsmanship:</strong> We believe in offering footwear that stands the test of time, crafted with precision and care to provide lasting comfort and style</li>
        <li><strong>Local Support:</strong> Reed's Shoe Emporium proudly supports local designers and artisans, showcasing the rich talent within Cape Town and South Africa</li>
        <li><strong>Customer Satisfaction:</strong> Our customers are at the heart of everything we do. We strive to exceed expectations, providing personalized service to help you find the perfect pair for any occasion</li>
        <li><strong>Style Diversity:</strong> Embracing the diverse styles of Cape Town, our collection reflects a fusion of global trends and local influences, ensuring there's something for everyone</li>
    </ul>
</div>