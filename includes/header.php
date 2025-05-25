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
        <h1>EasyEV-Charging</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hello, <?= $_SESSION['user']['name'] ?> (<?= $_SESSION['user']['type'] ?>)</p>
            <a href="../public/logout.php" style="color:white;">Logout</a>
        <?php else: ?>
            <a href="../public/login.php" style="color:white;">Login</a> |
            <a href="../public/register.php" style="color:white;">Register</a>
        <?php endif; ?>
    </header>
    <main style="padding:20px;">
