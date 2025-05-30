<?php
require_once '../init.php';
require_once '../config/db.php';

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
    WHERE c.user_id = ? AND c.checkout_time IS NULL
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Currently Charging</h2>

        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>Location</th>
                    <th>Check-in Time</th>
                    <th>Cost/Hour ($)</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['description'] ?></td>
                        <td><?= $row['checkin_time'] ?></td>
                        <td>
                            <?php
                            $costQuery = $conn->prepare("SELECT cost_per_hour FROM charging_locations WHERE location_id = ?");
                            $costQuery->bind_param("i", $row['location_id']);
                            $costQuery->execute();
                            $cost = $costQuery->get_result()->fetch_assoc()['cost_per_hour'];
                            echo $cost;
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>You are not currently charging at any location.</p>
        <?php endif; ?>
    </div>

<?php include '../includes/footer.php'; ?>