<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../CSS/ContactUsStyles.css">
</head>

<body>
    <!--Navigation-->
    <script src="../JavaScript/LoadHTML.js"></script>
    <nav class="navbar"><div id="navbar-placeholder"></div></nav>
    <script> loadHTML('../HTML/NavigationBar.html', 'navbar-placeholder'); </script>

    <!--Contact Us Form-->
    <div class="message-container">
        <h2>Contact Us</h2>
        <p>Please fill out the form below to contact us.</p>
        <form id="contactForm" action="ContactUsPage.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>    
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" id="sendMail" name="sendMail">Send</button>
        </form>
    </div>
    <div id="notification" class="notification"></div>

    <!-- PHP to send email to admin -->
    <?php
        if (isset($_POST['sendMail'])) {
            
            // Get form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            // Set email parameters
            $to = "raypersonaldrive@gmail.com";
            $subject = "Message from Contact Form";
            $mailheader = "From: The Website";
            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Message:\n$message";
            

            // Send email
            if (mail($to, $subject, $body, $mailheader)) {
                echo "<script> alert('Your message has been sent successfully.'); </script>";
                header("Location: ContactUsPage.php");
            } else {
                echo "<script> alert('There was an error sending your message.'); </script>";
                echo "There was an error sending your message.";
            }
        }
    ?>
</body>
</html>