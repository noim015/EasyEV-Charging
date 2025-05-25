<?php
require_once '../init.php';

if (!isUser()) {
    echo "You are not authorized to access this page.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - EasyEV-Charging</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h2>Welcome User, <?= $_SESSION['user']['name'] ?>!</h2>

    <ul>
        <li><a href="view_available_locations.php">View Available Charging Stations</a></li>
        <li><a href="checkin.php">Check-In to Charge</a></li>
        <li><a href="checkout.php">Check-Out</a></li>
        <li><a href="my_locations.php">My Charging History</a></li>
        <li><a href="my_current_charging.php">Currently Charging</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
