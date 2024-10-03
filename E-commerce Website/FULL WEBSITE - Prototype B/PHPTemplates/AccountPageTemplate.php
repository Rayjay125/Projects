<?php 
    // Conditionally start session
    if (session_status() == PHP_SESSION_NONE) {
        include "../PHP/DatabaseConnectionAndSessionStart.php";
    }

    // Make this particular file look blank, but not the pages where it is included
    if (basename($_SERVER['PHP_SELF']) == 'AccountPageTemplate.php'){
        echo '<link rel="stylesheet" href="../CSS/MakeBlankPage.css">'; 
    }
?>


<link rel="stylesheet" href="../CSS/AccountPageStyles.css">


<!-- php code to fetch the user's info -->
<?php
    // Prepare the SQL statements
    $sql = "SELECT Address,ID,Email,PhoneNumber FROM Persons WHERE username = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters, geting username from session
    $username = $_SESSION['username'];
    $stmt->bind_param("s", $username);

    // Execute the select statement
    if ($stmt->execute()) {
        // Bind result to variables
        $stmt->bind_result($dbAddress, $dbID, $dbEmail, $dbPhoneNumber);
        $stmt->fetch();
    }

    // Close statement
    $stmt->close();
?>

<!--My account form-->
<div class="form-container">
    <h2>My Account</h2>
    <form id="updateForm" autocomplete="off" action = "../PHPTemplates/AccountPageTemplate.php" method = "POST">
        <!--Input to disable autocompletion by the browser-->    
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        
        <!--The rest of the form-->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value= <?php echo $username;?> required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value=<?php echo $dbAddress;?> required>
        </div>
        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value=<?php echo $dbID;?> >
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value=<?php echo $dbEmail;?> required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value=<?php echo $dbPhoneNumber;?> required>
        </div>
        <div> 
            <button type="submit" id = "update" name = "update">Update Information</button><br><br>
            <button type="submit" id = "cancel" name = "cancel" style = "background-color: orange">Cancel</button>
        </div>
    </form>
</div>

<!-- Password Change Form -->
<div class="form-container">
    <form id="updateForm" autocomplete="off" action = "../PHPTemplates/AccountPageTemplate.php" method = "POST">
        <!--Input to disable autocompletion by the browser-->    
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        
        <!--The rest of the form-->
        <h2> Change Password </h2>
        <div class="password-container">
            <input type="password" id="oldPassword" name="oldPassword" placeholder="Enter old password" value="">
            <span class="password-toggle" id="toggleButton1" onclick="togglePasswordVisibility('oldPassword', 'toggleButton1')">Show</span>
        </div><br>
        <div class="password-container">
            <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password">
            <span class="password-toggle" id="toggleButton2" onclick="togglePasswordVisibility('newPassword', 'toggleButton2')">Show</span>
        </div><br>
        <div class="password-container">
            <input type="password" id="newPassword2" name="newPassword2" placeholder="Re-enter new password">
            <span class="password-toggle" id="toggleButton3" onclick="togglePasswordVisibility('newPassword2', 'toggleButton3')">Show</span>
        </div><br>      
        <div> 
            <button type="submit" id = "updatePassword" name = "updatePassword">Change Password</button><br><br>
            <button type="submit" id = "cancel" name = "cancel" style = "background-color: orange">Cancel</button>
        </div>
    </form>
</div>

<!-- Disable Account Form -->
<div class="form-container">
    <form id="updateForm" autocomplete="off" action = "../PHPTemplates/AccountPageTemplate.php" method = "POST">
        <!--Input to disable autocompletion by the browser-->    
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        
        <!--The rest of the form-->
        <h2> Reactivate or Deactivate This Account </h2>     
        <div> 
            <button type="submit" id = "update" name = "update">Reactivate</button><br><br>
            <button type="submit" id = "cancel" name = "cancel" style = "background-color: orange">Deactivate</button>
            <p style ="text-align: center">This account will be deleted automatically after 5 months of deactivation</p>
        </div>
    </form>
</div>

<script src="../JavaScript/MyAccountPageScript.js"></script>
<script src="../JavaScript/InputVisibilityToggleScript.js"></script>


<!-- php code to update the user's info -->
<?php 
    // Prepare the SQL statements
    $sql = "UPDATE Persons SET Username = ?,Address = ?,ID = ?,Email = ?,PhoneNumber = ? WHERE Username = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    //When the Update button is clicked
    if (isset($_POST['update'])){
        $newUsername = $_POST['username'];
        $newAddress = $_POST['address'];
        $newID = $_POST['id'];
        $newEmail = $_POST['email'];
        $newPhoneNumber = $_POST['phone'];

        // Bind parameters, geting username from session
        $stmt->bind_param("ssssss", $newUsername,$newAddress,$newID,$newEmail,$newPhoneNumber,$username);

        // Execute the update statement
        if ($stmt->execute()) {
            echo "<script> alert('User info updated successfully!'); </script>";
            echo $_SESSION['accountRedirectStatement'];  // REMEMBER TO ADD SPECIFIC REDIRECT STATEMENT TO THE PAGE WHERE THIS TEMPLATE IS USED
        } else {
            echo "<script> alert('Error updating user info!') </script>;";
            echo "Error updating user info: " . $stmt->error;
            echo $_SESSION['accountRedirectStatement'];
        }
    }

    // Close statement
    $stmt->close();
?>

<!-- php code to change the user's password -->
<?php  
    // Prepare the SQL statement
    $sql = "SELECT Password FROM Persons WHERE username = ?";
    $sql2 = "UPDATE Persons SET Password = ? WHERE Username = ?";

    $stmt = $conn->prepare($sql);
    $stmt2 = $conn->prepare($sql2);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    if ($stmt2 === false) {
        die("Error preparing statement: " . $conn->error);
    }

    //When the updatePassword button is clicked
    if (isset($_POST['updatePassword'])){
        // Bind parameters, geting username from session
        $username = $_SESSION['username'];
        $stmt->bind_param("s", $username);

        // Execute the first statement
        if ($stmt->execute()) {
            // Bind result to variables
            $stmt->bind_result($dbPassword);
            $stmt->fetch();

            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPassword2 = $_POST['newPassword2'];

            if ($oldPassword === $dbPassword) {
                // Passwords match, user is authenticated
                if ($newPassword === $newPassword2){
                    // Close first statement
                    $stmt->close();
                    // Bind parameters, geting username from session
                    $stmt2->bind_param("ss", $newPassword,$username);
                    // Execute the second statement
                    if ($stmt2->execute()) {
                        echo "<script> alert('Password change was successful!'); </script>";
                        echo $_SESSION['accountRedirectStatement'];
                    } else {
                        // Error executing statement
                        echo "Error: " . $stmt2->error;
                    }
                } else {
                    //New passwords are not the same
                    echo "<script> alert('The new password is not the same!'); </script>";
                    echo $_SESSION['accountRedirectStatement'];
                }
            } else {
                // Old password and database password don't match
                echo "<script> alert('Incorrect password!'); </script>";
                echo $_SESSION['accountRedirectStatement'];

            }
        } else {
            // Error executing statement
            echo "Error: " . $stmt->error;
            // Close first statement
            $stmt->close();
        }
    }

    // Close second statement
    $stmt2->close();
?>

<!-- PHP code to cancel any inputs made on the page -->
<?php 
    if(isset($_POST['cancel'])){
        echo $_SESSION['accountRedirectStatement'];
    }
?>
