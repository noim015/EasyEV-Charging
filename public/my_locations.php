<?php
require_once '../init.php';

if (!isUser()) {
    echo "Unauthorized access.";
    exit;
}

$userId = $_SESSION['user']['id'];
$db = new Database();
$conn = $db->connect();

$sql = "
    SELECT c.*, l.description 
    FROM checkins c 
    JOIN charging_locations l ON c.location_id = l.location_id 
    WHERE c.user_id = ? AND c.checkout_time IS NOT NULL
    ORDER BY c.checkout_time DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Charging History</title>
</head>
<body>
    <h2>My Charging History</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Location</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
                <th>Total Cost ($)</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['checkin_time'] ?></td>
                    <td><?= $row['checkout_time'] ?></td>
                    <td><?= $row['total_cost'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No charging history found.</p>
    <?php endif; ?>
</body>
</html>
