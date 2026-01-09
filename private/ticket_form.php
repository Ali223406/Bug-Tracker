<?php
session_start();
if (!isset($_SESSION['connexion']) || $_SESSION['connexion'] !== true) { // Check if user is logged in
header('Location: ../public/login.php'); // Redirect to login page if not logged in
exit(); // Ensure no further code is executed
}
//connect to the database
require_once '../config/config.php';
// User is logged in, proceed with displaying the ticket
//Recuperer les categories
$categories= $pdo->query("SELECT id_category, Title FROM category")->fetchAll(PDO::FETCH_ASSOC);
//Recuper les users
$users= $pdo->query("SELECT id_user, Name FROM user")->fetchAll(PDO::FETCH_ASSOC);
// If editing an existing ticket, fetch its data
$ticket = null;
if (isset($_GET['id_ticket']) && is_numeric($_GET['id_ticket'])) {
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE id_ticket = ?");
$stmt->execute([(int) $_GET['id_ticket']]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($ticket) && $ticket ? 'Edit Ticket' : 'Create Ticket' ?></title>
<link rel="stylesheet" href="../public/style.css">
</head>
<body>
<h2>Create a Ticket</h2>

<form method="POST" action="ticket_save.php">
<?php if (isset($ticket) && $ticket): ?>
<input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket['id_ticket']) ?>">
<?php endif; ?>

<label for="title">Title:</label>
<input type="text" id="title" name="title" required value="<?= isset($ticket) ? htmlspecialchars($ticket['Title']) : '' ?>"><br><br>
<label for="status">Status:</label>
<select id="status" name="status" required>
<option value="0" <?= isset($ticket) && $ticket['Status'] == 0 ? 'selected' : '' ?>>open</option>
<option value="1" <?= isset($ticket) && $ticket['Status'] == 1 ? 'selected' : '' ?>>In Progress</option>
<option value="2" <?= isset($ticket) && $ticket['Status'] == 2 ? 'selected' : '' ?>>Closed</option>
</select><br><br>
<label for="priority">Priority:</label>
<select id="priority" name="priority" required>
<option value="0" <?= isset($ticket) && $ticket['Priority'] == 0 ? 'selected' : '' ?>>Low</option>
<option value="1" <?= isset($ticket) && $ticket['Priority'] == 1 ? 'selected' : '' ?>>Medium</option>
<option value="2" <?= isset($ticket) && $ticket['Priority'] == 2 ? 'selected' : '' ?>>High</option>
</select><br><br>
<label for="category">Category:</label>
<select id="category" name="category" required>
<?php foreach ($categories as $category): ?>
<option value="<?= htmlspecialchars($category['id_category']) ?>" <?= isset($ticket) && $ticket['Category_id'] == $category['id_category'] ? 'selected' : '' ?>><?= htmlspecialchars($category['Title']) ?></option>
<?php endforeach; ?>
</select><br><br>
<label for="assigned_to">Assigned To:</label>
<select id="assigned_to" name="assigned_to">
<option value=" ">Unassigned</option>
<?php foreach ($users as $index => $user): ?>
<option value="<?= htmlspecialchars($user['id_user']) ?>" <?= isset($ticket) && $ticket['Assigned_to'] == $user['id_user'] ? 'selected' : '' ?>><?= htmlspecialchars($user['Name']) ?></option>
<?php endforeach; ?>
</select><br><br>
<label for="resolved_at">Resolved At:</label><br>
<input type="datetime-local" id="resolved_at" name="resolved_at" value="<?= isset($ticket) && $ticket['Resolved_at'] ? date('Y-m-d\TH:i', strtotime($ticket['Resolved_at'])) : '' ?>"><br><br>
<button type="submit">Save Ticket</button>

</form>
<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
