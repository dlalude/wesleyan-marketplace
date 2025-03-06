<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif (strlen($password) < 10) {  // ✅ Enforce minimum password length
        $error_message = "Password must be at least 10 characters long.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error_message = "Username already exists.";
        } else {
            // Insert new user into database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Registration failed. Please try again.";
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | College Marketplace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>College Marketplace</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <section class="form-container">
        <h2>Register</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Choose a Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </section>
</body>
</html>
