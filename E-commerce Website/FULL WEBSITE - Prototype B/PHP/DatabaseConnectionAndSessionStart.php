<?php
//Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "reedshoeemporiumdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// For troubleshooting - Check connection (un-comment the code below to check)
/*
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo '<script> alert("The connection was successful"); </script>';
}
*/
?>