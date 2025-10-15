<?php
// The password you want to use
$passwordToHash = 'Sumit'; // You can change 'password' to anything you want

// Generate the secure hash
$hashedPassword = password_hash($passwordToHash, PASSWORD_DEFAULT);

// Display the hash
echo '<h3>Copy this hash into your database:</h3>';
echo '<p>Password: ' . htmlspecialchars($passwordToHash) . '</p>';
echo '<textarea rows="3" style="width: 100%;">' . $hashedPassword . '</textarea>';
?>