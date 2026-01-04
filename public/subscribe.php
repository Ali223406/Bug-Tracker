<?php
session_start();
require_once '../config/config.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
  
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

      if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $passwordConfirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id_user FROM user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Insert new user into database
            $stmt = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $success = "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "An error occurred during registration. Please try again.";
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
    <title>Subscribe to BugTracker</title>
</head>
<body>  
    <h2>Subscribe to BugTracker</h2>
    <?php
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    if (!empty($success)) {
        echo "<p style='color:green;'>$success</p>";
    }
    ?>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="password_confirm"> Password verification:</label>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>
        <button type="submit">Subscribe</button>
    </form>
</body>
</html>
