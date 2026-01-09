
<?php
session_start();

if (!isset($_SESSION['user_id'])) { // Check if user is logged in
header('Location: ../public/login.php'); // Redirect to login page if not logged in
exit(); // Ensure no further code is executed
}
//connect to the database
require_once '../config/config.php';
// User is logged in, proceed with saving the ticket

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id_ticket = isset($_POST['id_ticket']) ? (int) $_POST['id_ticket'] : null;
$title = trim($_POST['title'] ?? '');
$category = (int) ($_POST['category'] ?? 0);
$priority = (int) ($_POST['priority'] ?? 0);
$created_by = $_SESSION['user_id'];
$status = (int) ($_POST['status'] ?? 0);
$created_at = date('Y-m-d H:i:s');
$assigned_to = (int) ($_POST['assigned_to'] ?? 0);
$resolved_at = !empty($_POST['resolved_at']) ? $_POST['resolved_at'] : null;

if (empty($title) || !in_array($status, [0, 1, 2]) || !in_array($priority, [0, 1, 2]) || $category <= 0 ) {
die('Invalid input. Please go back and try again.');
}

try {
if ($id_ticket) {
// If id_ticket is provided, update the existing ticket
$stmt = $pdo->prepare("
UPDATE tickets
SET Title = ?, Category_id = ?, Priority = ?, Status = ?, Assigned_to = ?, Resolved_at = ?
WHERE id_ticket = ?");
$success = $stmt->execute([$title, $category, $priority, $status, $assigned_to, $resolved_at, $id_ticket]);
} else {
$stmt = $pdo->prepare("
INSERT INTO tickets
(Title, Category_id, Priority, Created_by, Status, Created_At, Assigned_to, Resolved_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$success = $stmt->execute([$title, $category, $priority, $created_by, $status, $created_at, $assigned_to, $resolved_at]);
}
// Redirect to dashboard after updating the ticket
if ($success) {
header('Location: dashboard.php');
exit;
} else {
die('Error saving ticket. Please try again.');
}
} catch (PDOException $e) {
die('Error saving ticket: ' . $e->getMessage());
}

} else {
// If not a POST request, redirect to ticket form
header('Location: ticket_form.php');
exit;
}
