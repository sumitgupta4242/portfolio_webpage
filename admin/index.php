<?php
require_once '../includes/db.php';
$error = '';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] === true) {
    header("location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Use password_verify for secure password checking
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_loggedin'] = true;
            header("location: dashboard.php");
            exit;
        } else {
            $error = 'The username or password was not valid.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="index.php" method="post">
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
        </form>
    </div>
</body>
</html>