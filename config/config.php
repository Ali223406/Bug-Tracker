<?php
$host = 'localhost';     // serveur local
$dbname = 'bugtracker';  // nom de ta base de données
$username = 'root';      // par défaut XAMPP
$password = '';          // par défaut XAMPP
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>