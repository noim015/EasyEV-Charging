<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>EasyEV-Charging</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
     <header style="background:#333;color:#fff;padding:10px;">
        <div class="container">
            <h1><a href="../public/index.php">EasyEV-Charging</a></h1>
            <?php if (isset($_SESSION['user'])): ?>
                <p>Hello, <?= $_SESSION['user']['name'] ?> (<?= $_SESSION['user']['type'] ?>)</p>
                
                <!-- Dynamic navigation based on user role -->
                <nav>
                    <ul>
                        <?php if ($_SESSION['user']['type'] === 'admin'): ?>
                            <li><a href="../public/dashboard_admin.php" style="color:white;">Admin Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="../public/dashboard_user.php" style="color:white;">User Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="../public/logout.php" style="color:white;">Logout</a></li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main>
