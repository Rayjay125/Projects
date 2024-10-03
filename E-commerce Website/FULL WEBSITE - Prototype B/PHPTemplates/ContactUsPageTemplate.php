<?php 
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'ContactUsPageTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }
?>

<link rel="stylesheet" href="../CSS/ContactUsStyles.css">
<?php
    //Using prepared statement to get user's email from database
    // Prepare the SQL statement
    $sql = "SELECT Email FROM Persons WHERE username = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters, geting username from session
    $username = $_SESSION['username'];
    $stmt->bind_param("s", $username);

    // Execute the select statement
    if ($stmt->execute()) {
        // Bind result to variable
        $stmt->bind_result($dbEmail);
        $stmt->fetch();
    }
?>

<!--Contact us form-->
<div class="message-container">
    <h2>Contact Us</h2>
    <p>Please fill out the form below to contact us.</p>
    <form id="contactForm" action="UserContactUsPage.php" method="POST">
        <div class="form-group">
            <label for="name">Username:</label>
            <input type="text" id="name" name="name" value= <?php echo $username;?> disabled>
        </div>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value= <?php echo $dbEmail;?> disabled>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit" id="sendMail" name="sendMail">Send</button>
    </form>
</div>
<div id="notification" class="notification"></div>

<?php 
    if (isset($_POST['sendMail'])) {
        // Get form data
        $name = $username;
        $email = $dbEmail;
        $message = $_POST['message'];

        // Set email parameters
        $to = "rayhanalobwede@gmail.com";
        $subject = "Message from Contact Form";
        $mailheader = "From: The Website";
        $body = "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Message:\n$message";
        

        // Send email
        if (mail($to, $subject, $body, $mailheader)) {
            echo "<script> alert('Your message has been sent successfully.'); </script>";
            echo "<script> location.replace('{$_SERVER['HTTP_REFERER']}'); </script>";
        } else {
            echo "<script> alert('There was an error sending your message.'); </script>";
            echo "There was an error sending your message.";
            echo "<script> location.replace('{$_SERVER['HTTP_REFERER']}'); </script>";
        }
    }
?>