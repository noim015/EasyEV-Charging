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

<!-- Hero Section with Background Image -->
<div class="hero-section">
    <div class="hero-content">
        <div class="container">
            <h2>Welcome to <span style="color: #FFD700;">EasyEV-Charging</span></h2>
            <p>Charge your electric vehicle smartly and securely at any time.</p>
            <div class="hero-buttons">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn-outline">Register</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
