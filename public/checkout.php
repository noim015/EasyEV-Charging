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

$msg = '';
$activeSession = null;

// Get current active session (if any)
$stmt = $conn->prepare("
    SELECT c.*, l.description, l.cost_per_hour
    FROM checkins c
    JOIN charging_locations l ON c.location_id = l.location_id
    WHERE c.user_id = ? AND c.checkout_time IS NULL
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $activeSession = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $checkoutTime = date('Y-m-d H:i:s');

        $start = new DateTime($activeSession['checkin_time']);
        $end = new DateTime($checkoutTime);
        $hours = max(1, ceil(($end->getTimestamp() - $start->getTimestamp()) / 3600));

        $totalCost = $hours * $activeSession['cost_per_hour'];

        $update = $conn->prepare("
            UPDATE checkins 
            SET checkout_time = ?, total_cost = ?
            WHERE id = ?
        ");
        $update->bind_param("sdi", $checkoutTime, $totalCost, $activeSession['id']);

        if ($update->execute()) {
            $msg = "Check-out successful! Duration: {$hours} hr(s), Total Cost: \${$totalCost}";
            $activeSession = null; // Clear session
        } else {
            $msg = "Check-out failed.";
        }
    }
} else {
    $msg = "No active charging session found.";
}
?>
<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Check-Out - EasyEV-Charging</title>
</head>
<body>
    <h2>End Charging (Check-Out)</h2>

    <?php if ($activeSession): ?>
        <p>Charging at: <strong><?= $activeSession['description'] ?></strong></p>
        <p>Started at: <?= $activeSession['checkin_time'] ?></p>
        <p>Cost per hour: $<?= $activeSession['cost_per_hour'] ?></p>

        <form method="POST">
            <input type="submit" value="Confirm Check-Out">
        </form>
    <?php endif; ?>

    <p style="color:green"><?= $msg ?></p>
</body>
</html>
<?php include '../includes/footer.php'; ?>