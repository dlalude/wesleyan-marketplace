<?php
$servername = "localhost"; // XAMPP runs MySQL locally
$username = "root"; // Default MySQL username
$password = ""; // Default MySQL password in XAMPP (leave empty)
$database = "app_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
