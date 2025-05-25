<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = $_POST['description'] ?? '';
    $stations = $_POST['num_stations'] ?? 0;
    $cost = $_POST['cost_per_hour'] ?? 0.00;

    $location = new Location();
    if ($location->addLocation($desc, (int)$stations, (float)$cost)) {
        $msg = "Location added successfully.";
    } else {
        $msg = "Failed to add location.";
    }
}
?>
<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Charging Location</title>
</head>
<body>
    <h2>Add New Charging Location</h2>
    <form method="POST">
        <label>Description:</label><br>
        <input type="text" name="description" required><br><br>

        <label>Number of Stations:</label><br>
        <input type="number" name="num_stations" required><br><br>

        <label>Cost Per Hour ($):</label><br>
        <input type="number" name="cost_per_hour" step="0.01" required><br><br>

        <input type="submit" value="Add Location">
    </form>
    <p style="color:green"><?= $msg ?></p>
</body>
</html>
<?php include '../includes/footer.php'; ?>