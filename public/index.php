<?php
require_once '../init.php';

if (isLoggedIn()) {
    // Redirect user to their dashboard
    if (isAdmin()) {
        header('Location: dashboard_admin.php');
    } else {
        header('Location: dashboard_user.php');
    }
    exit;
}
?>

<?php include '../includes/header.php'; ?>

<h2>Welcome to EasyEV-Charging</h2>
<p>This is an online platform to check-in and charge your electric vehicle with ease.</p>

<p><a href="login.php">Login</a> or <a href="register.php">Register</a> to begin.</p>

<?php include '../includes/footer.php'; ?>
