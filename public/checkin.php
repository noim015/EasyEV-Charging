<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isUser()) {
    echo "Unauthorized access.";
    exit;
}

$location = new Location();
$locations = $location->getAvailableLocations();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $locId = $_POST['location_id'] ?? 0;
    $userId = $_SESSION['user']['id'];
    $checkinTime = date('Y-m-d H:i:s');

    $db = new Database();
    $conn = $db->connect();

    // Check if already checked-in
    $check = $conn->prepare("SELECT * FROM checkins WHERE user_id = ? AND checkout_time IS NULL");
    $check->bind_param("i", $userId);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        $msg = "You already have an active charging session.";
    } else {
        $stmt = $conn->prepare("INSERT INTO checkins (user_id, location_id, checkin_time) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $userId, $locId, $checkinTime);
        if ($stmt->execute()) {
            // Get cost per hour
            $costStmt = $conn->prepare("SELECT cost_per_hour FROM charging_locations WHERE location_id = ?");
            $costStmt->bind_param("i", $locId);
            $costStmt->execute();
            $cost = $costStmt->get_result()->fetch_assoc()['cost_per_hour'];

            $msg = "Check-in successful at " . $checkinTime . ". Cost per hour: $" . number_format($cost, 2);
        } else {
            $msg = "Check-in failed.";
        }
    }
}
?>
<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Check-In - EasyEV-Charging</title>
</head>
<body>
    <h2>Start Charging (Check-In)</h2>

    <form method="POST">
        <label>Select Charging Location:</label><br>
        <select name="location_id" required>
            <option value="">--Select--</option>
            <?php foreach ($locations as $loc): ?>
                <option value="<?= $loc['location_id'] ?>">
                    <?= $loc['description'] ?> (Available: <?= $loc['available'] ?> | $<?= $loc['cost_per_hour'] ?>/hr)
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Check-In">
    </form>

    <p style="color:green"><?= $msg ?></p>
</body>
</html>
<?php include '../includes/footer.php'; ?>