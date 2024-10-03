<?php 
    //Connecting to database and starting session
    include "DatabaseConnectionAndSessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
</head>
<body>
    <!--Navigation-->
    <?php 
        include "AdminNavigationBar.php";
    ?>

    <!--Include page template-->
    <?php 
        $_SESSION['accountRedirectStatement'] = "<script> location.replace('../PHP/AdminAccountPage.php'); </script>";
        include "../PHPTemplates/AccountPageTemplate.php";
    ?>

    <!-- Form to upgrade account to admin-->
    <div class="form-container">
        <h2>Upgrade Another Account To Admin</h2>
        <form id="upgradeForm" autocomplete="off" action = "AdminAccountPage.php" method = "POST">
            <!--Input to disable autocompletion by the browser-->    
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            
            <!--The rest of the form-->
            <div class="form-group">
                <label for="accountUsername">Username:</label>
                <input type="text" id="accountUsername" name="accountUsername" placeholder="Enter account username" required>
            </div>
            <button type="submit" id="upgradeAccount" name="upgradeAccount">Upgrade Account</button>
        </form>
    </div>

    <!-- PHP code to upgrade account to admin -->
    <?php 
        // Prepare the SQL statements
        $upgradeSql = "UPDATE Persons SET AccountType = ? WHERE Username = ?";
        $checkSql = "SELECT Username, AccountType FROM persons WHERE username = ?";

        $upgradeStmt = $conn->prepare($upgradeSql);
        $checkStmt = $conn->prepare($checkSql);

        if ($upgradeStmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($checkStmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        //When the Update button is clicked
        if (isset($_POST['upgradeAccount'])){
            $accountType = "admin";
            $accountUsername = $_POST['accountUsername'];

            $checkStmt->bind_param("s", $accountUsername);

            // Execute statement
            if ($checkStmt->execute()) {
                // Bind result to variables
                $checkStmt->bind_result($dbAccountUsername, $dbUserAccountType);
                $checkStmt->fetch();

                if ($dbAccountUsername){
                    if ($dbUserAccountType === "user"){
                        // Close statement
                        $checkStmt->close();

                        // Bind parameters, geting username from session
                        $upgradeStmt->bind_param("ss", $accountType,$accountUsername);

                        // Execute the update statement
                        if ($upgradeStmt->execute()) {
                            echo "<script> alert('Account has been upgraded successfully!'); </script>";
                        } else {
                            echo "<script> alert('Error upgrading account!') </script>;";
                            echo "Error upgrading account: " . $upgradeStmt->error;
                        }
                    } else {
                        echo "<script> alert('User is already an Admin!') </script>;";
                    }
                } else {
                    echo "<script> alert('User does not exist!') </script>;";
                }
            }
        }

        // Close statement
        $upgradeStmt->close();
    ?>

</body>
</html>