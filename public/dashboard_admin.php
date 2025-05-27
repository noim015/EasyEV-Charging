<?php
require_once '../init.php';

if (!isAdmin()) {
    echo "You are not authorized to access this page.";
    exit;
}
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Welcome Admin, <?= $_SESSION['user']['name'] ?>!</h2>

        <ul class="listing-item">
            <li><a href="add_location.php">Add Charging Location</a></li>
            <li><a href="edit_location.php">Edit Charging Location</a></li>
            <li><a href="view_all_locations.php">View All Locations</a></li>
            <li><a href="view_full_locations.php">View Full Locations</a></li>
            <li><a href="view_available_locations.php">View Available Locations</a></li>
            <li><a href="view_all_users.php">View All Users</a></li>
            <li><a href="view_checkedin_users.php">View Users Checked-In</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

<?php include '../includes/footer.php'; ?>