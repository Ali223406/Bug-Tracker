<?php
session_start();
if (!isset($_SESSION['connexion']) || $_SESSION['connexion'] !== true) { // Check if user is logged in
header('Location: ../public/login.php'); // Redirect to login page if not logged in
exit(); // Ensure no further code is executed
}

//connect to the database
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id_ticket = (int) ($_POST['id_ticket'] ?? 0);
$status = (int) ($_POST['status'] ?? -1);

if ($id_ticket <= 0 || !in_array($status, [0, 1, 2])) {
die('Invalid input. Please go back and try again.');
}

try {
$stmt = $pdo->prepare("UPDATE tickets SET Status = ? WHERE id_ticket = ?");
$stmt->execute([$status, $id_ticket]);
} catch (PDOException $e) {
die('Error updating ticket: ' . $e->getMessage());
}

// Redirect to dashboard after updating the ticket
header('Location: dashboard.php');
exit;
} else {
// If not a POST request, redirect to dashboard
header('Location: dashboard.php');
exit;
}
?>
