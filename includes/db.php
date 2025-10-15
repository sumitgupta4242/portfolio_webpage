<?php
// --- Database Configuration ---
$db_host = 'localhost';
$db_name = 'portfolio_db';
$db_user = 'root'; // Your database username
$db_pass = '';     // Your database password

// --- Create PDO Connection ---
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// --- Start Session ---
// This is needed for the admin login system
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
