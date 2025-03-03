<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Ensure ID is provided in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid listing ID.");
}

$id = $_GET['id'];

// Fetch the listing to ensure the logged-in user owns it
$stmt = $conn->prepare("SELECT username FROM listings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Listing not found.");
}

$row = $result->fetch_assoc();

// Check if the logged-in user is the owner
if ($row["username"] !== $_SESSION["username"]) {
    die("You do not have permission to delete this listing.");
}

// Proceed with deletion
$delete_stmt = $conn->prepare("DELETE FROM listings WHERE id = ?");
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting listing.";
}
?>
