<?php
session_start();           // Start the session

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
require_once __DIR__ . '/config/config.php';  // <- chemin vers ton config.php

// Check if user is logged in
if (isset($_SESSION['connexion']) && $_SESSION['connexion'] === true) {   // if logged in
    header('Location: private/dashboard.php');     // Redirect to dashboard
} else {
    header('Location: public/login.php');             // Redirect to login page if not logged in
}
exit();