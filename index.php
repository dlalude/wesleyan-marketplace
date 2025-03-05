<?php
session_start();
include 'db.php';

// Fetch all listings from the database
$stmt = $conn->prepare("SELECT * FROM listings ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Marketplace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>College Marketplace</h1>
    <nav>
        <a href="create.php">Create Listing</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <h2>All Listings</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="listing">
                <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p class="price">$<?= htmlspecialchars($row['price']) ?></p>
                <p class="seller">Listed by: <?= htmlspecialchars($row['username']) ?></p>

                <!-- Show Edit/Delete only for the owner -->
                <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $row['username']): ?>
                    <a href="update.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No listings available.</p>
    <?php endif; ?>
</main>

</body>
</html>
