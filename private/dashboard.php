<?php
session_start();
if (!isset($_SESSION['connexion']) || $_SESSION['connexion'] !== true) { // Check if user is logged in
header('Location: ../public/login.php'); // Redirect to login page if not logged in
exit(); // Ensure no further code is executed
}

//connect to the database
require_once '../config/config.php';
// User is logged in, proceed with displaying the dashboard
function statusLabel($status) {
switch ($status) {
case 0:
return 'open';
case 1:
return 'In Progress';
case 2:
return 'Closed';
default:
return 'Unknown';
}
}
function priorityLabel($priority) {
switch ($priority) {
case 0:
return 'Low';
case 1:
return 'Medium';
case 2:
return 'High';
default:
return 'Unknown';
}
}
//FILTRES
$where = [];
$params = [];

//FILTER MY TICKETS
if (isset($_GET['filter']) && $_GET['filter'] === 'my_tickets') {
$where[] = 't.Created_by = :user_id';
$params[':user_id'] = $_SESSION['user_id'];
}
//FILTER BY STATUS
if (isset($_GET['status']) && in_array($_GET['status'], ['0', '1', '2'])) {
$where[] = 't.Status = :status';
$params[':status'] = (int) $_GET['status'];
}
//FILTER PAR CATEGORY
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
$where[] = 't.Category_id = :category_id';
$params[':category_id'] = (int) $_GET['category'];
}
$whereSql = '';
if (!empty($where)) {
$whereSql = 'WHERE ' . implode(' AND ', $where);
}
$sql = "
SELECT
t.id_ticket,
t.Title,
t.Status,
t.Priority,
t.Created_At,
t.Resolved_at,
c.Title AS Category,
u1.Name AS Creator,
u2.Name AS Assigned_User

FROM tickets t
LEFT JOIN category c ON t.Category_id = c.id_category
LEFT JOIN user u1 ON t.Created_by = u1.id_user
LEFT JOIN user u2 ON t.Assigned_to = u2.id_user
$whereSql
ORDER BY t.Created_At DESC";
$stmt = $pdo->prepare($sql);
if (!$stmt->execute($params)) {
$errorInfo = $stmt->errorInfo();
die('SQL Error: ' . $errorInfo[2]);
}
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//STATISTIQUES A IMPLEMENTER PLUS TARD
$totalTickets = $pdo->query("SELECT COUNT(*) FROM tickets")->fetchColumn();
$openTickets = $pdo->query("SELECT COUNT(*) FROM tickets WHERE Status = 0")->fetchColumn();
$inProgressTickets = $pdo->query("SELECT COUNT(*) FROM tickets WHERE Status = 1")->fetchColumn();
$closedTickets = $pdo->query("SELECT COUNT(*) FROM tickets WHERE Status = 2")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="../public/style.css">
</head>
<body>
<h1>Welcome to your Dashboard</h1>
<p>You are now in BugTracker.</p>
<h3><em>Hello <?=$_SESSION['name']; ?>, you are successfully logged in!</em></h3>
<p><a href="../public/logout.php">Logout</a></p>

<!-- Future implementation for displaying tickets will go here -->
<p><a href="ticket_form.php">Create a new Ticket</a></p>
<!-- Statistics -->
<h2>Statistics</h2>
<ul>
<li>Total Tickets: <?= $totalTickets ?></li>
<li>Open Tickets: <?= $openTickets ?></li>
<li>In Progress Tickets: <?= $inProgressTickets ?></li>
<li>Closed Tickets: <?= $closedTickets ?></li>

<!-- Filters -->
<h2>Filters</h2>

<a href="dashboard.php?filter=all_tickets">All Tickets</a> |
<a href="dashboard.php?filter=my_tickets">My Tickets</a> |
<a href="dashboard.php?filter=all_tickets&category=1">Front-end</a> |
<a href="dashboard.php?filter=all_tickets&category=2">Back-end</a> |
<a href="dashboard.php?filter=all_tickets&category=3">Infrastructure</a>

<hr>
<h2>Tickets</h2>
<?php if (empty($tickets)): ?>
<p>No tickets found.</p>
<?php else: ?>
<table border="1" cellpadding="5" cellspacing="0">
<thead>
<tr>
<th>#</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Priority</th>
<th>Created At</th>
<th>Resolved At</th>
<th>Created By</th>
<th>Assigned To</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($tickets as $ticket): ?>
<tr>
<td><?= htmlspecialchars($ticket['id_ticket']) ?></td>
<td><?= htmlspecialchars($ticket['Title']) ?></td>
<td><?= htmlspecialchars($ticket['Category']) ?></td>
<td>
<form method="POST" action="ticket_update.php">
<input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket['id_ticket']) ?>">
<select name="status" onchange="this.form.submit()">
<option value="0" <?= $ticket['Status'] == 0 ? 'selected' : '' ?>>open</option>
<option value="1" <?= $ticket['Status'] == 1 ? 'selected' : '' ?>>In Progress</option>
<option value="2" <?= $ticket['Status'] == 2 ? 'selected' : '' ?>>Closed</option>
</select>
<td><?= htmlspecialchars(priorityLabel($ticket['Priority'])) ?></td>
<td><?= htmlspecialchars($ticket['Created_At']) ?></td>
<td><?= htmlspecialchars($ticket['Resolved_at']) ?></td>
<td><?= htmlspecialchars($ticket['Creator']) ?></td>
<td><?= htmlspecialchars($ticket['Assigned_User']) ?></td>
<td>
<a href="ticket_form.php?id_ticket=<?= $ticket['id_ticket'] ?>">Edit</a> |
<a href="ticket_delete.php?id_ticket=<?= $ticket['id_ticket'] ?>"
onclick="return confirm('Are you sure you want to delete this ticket?');">
Delete
</a>
</td>
</form>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

</body>
</html>
