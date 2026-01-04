<?php
session_start();
if (!isset($_SESSION['user_id'])) {                         // Check if user is logged in
    header('Location: ../public/login.php');             // Redirect to login page if not logged in
    exit();                                      // Ensure no further code is executed
}

//connect to the database
require_once '../config/config.php';
// User is logged in, proceed with displaying the dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to your Dashboard</h1>
    <p>You are now in BugTracker.</p>
    <h3><em>Hello <?=$_SESSION['name']; ?>, you are successfully logged in!</em></h3>
    <p><a href="../public/logout.php">Logout</a></p>

    <!-- Tickets-->
     <h2>All Tickets</h2>
     <p>No tickets to display yet.</p>
     <!-- Future implementation for displaying tickets will go here -->
      <p><a href="ticket_form.php">Create a new Ticket</a></p>
    
</body>
</html>