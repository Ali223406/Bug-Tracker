<?php
require_once '../config/config.php';         // Connect to the database

//TEST TO CREATE NEW USER
$name = 'Test User';             //TEST NAME
$email = 'testuser@example.com';          //TEST EMAIL
$password = 'password123';             //TEST PASSWORD
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);     // Hash the password
$stmt = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");  // Prepare SQL statement to insert new user
$result = $stmt->execute([$name, $email, $hashedPassword]);                // Execute the insert statement
echo $result ? "User registered successfully.\n" : "Failed to register user.\n";    // Output result

//TEST TO CHECK IF USER EXIST
$stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");    // Prepare SQL statement to check for existing email
$stmt->execute([$email]);                          // Execute the statement
$exists = $stmt->fetch(PDO::FETCH_ASSOC);        // Fetch the user data
if ($exists) {                                     // If a record is found
    echo "User exists: " . $exists['Name'] . "\n";     // Output user name
} else {                                            // If no record is found
    echo "User does not exist.\n";            // Output user does not exist
}