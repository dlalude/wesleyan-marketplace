<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wesleyan Marketplace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Wesleyan Marketplace</h1>
        <nav>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="create.php">Create Listing</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="listings">
        <h2>Recent Listings</h2>
        <?php
        $result = $conn->query("SELECT * FROM listings ORDER BY id DESC");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='listing'>";
                echo "<h3>{$row['item_name']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<p class='price'>$ {$row['price']}</p>";
                echo "<p class='seller'>Posted by: {$row['username']}</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No listings available.</p>";
        }
        ?>
    </section>
</body>
</html>
