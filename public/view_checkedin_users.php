<?php
require_once '../init.php';
require_once '../config/db.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$conn = (new Database())->connect();

$sql = "
    SELECT u.name, u.email, l.description, c.checkin_time 
    FROM checkins c
    JOIN users u ON c.user_id = u.id
    JOIN charging_locations l ON c.location_id = l.location_id
    WHERE c.checkout_time IS NULL
";
$result = $conn->query($sql);
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Users Currently Checked-In</h2>
        <table border="1">
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Location</th>
                <th>Check-in Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['checkin_time'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

<?php include '../includes/footer.php'; ?>