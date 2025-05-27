<?php
require_once '../init.php';

if (!isUser()) {
    echo "You are not authorized to access this page.";
    exit;
}
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Welcome User, <?= $_SESSION['user']['name'] ?>!</h2>

        <ul class="listing-item">
            <li><a href="search_locations.php">Search Available Charging Stations</a></li>
            <li><a href="checkin.php">Check-In to Charge</a></li>
            <li><a href="checkout.php">Check-Out</a></li>
            <li><a href="my_locations.php">My Charging History</a></li>
            <li><a href="my_current_charging.php">Currently Charging</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

<?php include '../includes/footer.php'; ?>