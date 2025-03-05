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
        <h2>All Listings</h2>

        <?php
        $stmt = $conn->prepare("SELECT * FROM listings ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
                <div class="listing">
                    <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <p class="price">$ <?= htmlspecialchars($row['price']) ?></p>
                    <p class="seller">Listed by: <?= htmlspecialchars($row['username']) ?></p>

                    <?php if (isset($_SESSION["username"]) && $_SESSION["username"] === $row["username"]): ?>
                        <a href="update.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                    <?php endif; ?>
                </div>
        <?php
            endwhile;
        else:
            echo "<p>No listings available.</p>";
        endif;
        ?>
    </section>
</body>
</html>
