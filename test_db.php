<?php
require_once __DIR__ . '/config/config.php';  // Assurez-vous du bon chemin

try {
    $pdo->query("SELECT 1");
    echo "Connection MySQL OK !";
} catch (PDOException $e) {
    echo "Error MySQL : " . $e->getMessage();
}
