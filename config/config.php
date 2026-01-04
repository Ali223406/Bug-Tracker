<?php
//connexion a la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bugtracker', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    die("Could not connect to the database "   . $e->getMessage());
}
?>