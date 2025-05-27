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
     <header>
        
            <div class="container_top">
                <a href="../public/index.php"><img src="../assets/logo.png" alt="EasyEV-Charging"></a>  
                <nav>
                    <ul>
                        <li><a href="../public/index.php">Home</a></li>
                        <li><a href="../public/about.php">About</a></li>
                        <li><a href="../public/contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>       
            <div class="container">
                <?php if (isset($_SESSION['user'])): ?>
                  <div id="role_area">
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
                    </div>
                 <?php endif; ?>
            </div>
    </header>
    <main>
