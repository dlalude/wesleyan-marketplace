<?php
session_start();
include 'db.php';

// Check if user is logged in
$loggedInUser = $_SESSION["username"] ?? null;
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
        // Fetch all listings ordered by most recent
        $stmt = $conn->prepare("SELECT * FROM listings ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $isOwner = ($loggedInUser === $row["username"]); // Check if logged-in user owns the listing
        ?>
                <div class='listing'>
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p class='price'>$ <?php echo number_format($row['price'], 2); ?></p>
                    <p class='seller'>Posted by: <?php echo htmlspecialchars($row['username']); ?></p>

                    <?php if ($isOwner): ?>
                        <div class="actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                        </div>
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

