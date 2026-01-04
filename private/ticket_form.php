<?php
session_start();
if (!isset($_SESSION['id_user'])) {                         // Check if user is logged in
    header('Location: ../public/login.php');             // Redirect to login page if not logged in
    exit();                                      // Ensure no further code is executed
}
//connect to the database
require_once '../config/config.php';    
// User is logged in, proceed with displaying the ticket form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Ticket - BugTracker</title>
</head>
<body>  
    <h2>Create a Ticket</h2>
    <h3><em>Hello <?=$_SESSION['name']; ?>, Fill form!</em></h3>
    <form method="POST" action="process_ticket.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="1">Frontend</option>
            <option value="2">Backend</option>
            <option value="3">Infrastructure</option>
        
        </select><br><br>
        <label for="priority">Priority:</label>
        <select id="priority" name="priority" required>
            <option value="0">Low</option>
            <option value="1">Medium</option>
            <option value="2">High</option>
        </select><br><br>
        
        <button type="submit">Save Ticket</button>
       
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>