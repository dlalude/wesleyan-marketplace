<?php
$host = "sql303.infinityfree.com"; // MySQL Host Name from the table
$user = "if0_38463402";            // MySQL User Name from the table
$pass = "p7fbfUCne6pX";    // Your InfinityFree (vPanel) password
$dbname = "if0_38463402_if0_38463402_marketplace"; // MySQL DB Name from the table

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
