<?php
session_start();             // Start the session
if (!isset($_SESSION['connexion']) || $_SESSION['connexion'] !== true) {                         // Check if user is logged in
    header('Location: ../public/login.php');             // Redirect to login page if not logged in
    exit();                                      // Ensure no further code is executed
}

//connect to the database
require_once '../config/config.php';          
$id_ticket = (int) ($_GET['id_ticket'] ?? 0);         // Get ticket ID from GET parameters
if ($id_ticket <= 0) {                                // Validate ticket ID
    die('Invalid ticket ID.');              // Handle invalid ticket ID
}
try {
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id_ticket = ?");    // Prepare statement to delete the ticket
    $stmt->execute([$id_ticket]);                                 // Execute the delete statement
} catch (PDOException $e) {                                        // Handle any errors during deletion
    die('Error deleting ticket: ' . $e->getMessage());            // Handle any errors during the update
}
// Redirect to dashboard after deleting the ticket
header('Location: dashboard.php');
exit;
?>
