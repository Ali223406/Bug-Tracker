<?php
session_start();
require_once '../config/config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {

        $_SESSION['connexion'] = true;
        $_SESSION['name'] = $user['Name'];
        $_SESSION['user_id'] = $user['id_user'];

        // Redirection vers le dashboard
        header('Location: ../private/dashboard.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>    
</head>
<body>
    <h2>Login to BugTracker</h2>
    <?php if (!empty($error))
       echo "<p style='color:red;'>$error</p>";
    ?>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="subscribe.php">Subscribe here</a>.</p>
</body> 
</html>