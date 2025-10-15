<?php
// This must be the very first line in each protected file
require_once '../includes/db.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="edit_general.php">General Info</a></li>
                <li><a href="manage_skills.php">Manage Skills</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="../index.php" target="_blank">View Website</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content"></main>