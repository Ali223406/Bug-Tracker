<?php
require_once '../config/config.php';        // Connect to the database
//create ticket
$stmt = $pdo->prepare("INSERT INTO tickets (Title, Status, Priority, Category_id, Created_At, Assigned_to, Created_by) VALUES (?, 0, 1, 1, NOW(), 1, 1)");  // Prepare SQL statement to create a new ticket

$result = $stmt->execute(['Test Ticket']);         // Execute the insert statement
echo $result ? "Ticket created successfully.\n" : "Failed to create ticket.\n";         // Output result
//update ticket
$ticketId = $pdo->lastInsertId();                                  // Get the ID of the newly created ticket
$stmt = $pdo->prepare("UPDATE tickets SET Status = 1, Priority = 2 WHERE id_ticket = ?");  // Prepare SQL statement to update the ticket
$result = $stmt->execute([$ticketId]);                                                    // Execute the update statement
echo $result ? "Ticket updated successfully.\n" : "Failed to update ticket.\n";     // Output result
//delete ticket
$stmt = $pdo->prepare("DELETE FROM tickets WHERE id_ticket = ?");        // Prepare SQL statement to delete the ticket
$result = $stmt->execute([$ticketId]);                        // Execute the delete statement
echo $result ? "Ticket deleted successfully.\n" : "Failed to delete ticket.\n";          // Output result
?>
