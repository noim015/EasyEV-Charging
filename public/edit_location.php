<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$location = new Location();
$locations = $location->getAllLocations();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['location_id'] ?? 0;
    $desc = $_POST['description'] ?? '';
    $stations = $_POST['num_stations'] ?? 0;
    $cost = $_POST['cost_per_hour'] ?? 0.00;

    if ($location->updateLocation((int)$id, $desc, (int)$stations, (float)$cost)) {
        $msg = "Location updated successfully.";
    } else {
        $msg = "Update failed.";
    }
}

if (isset($_GET['id'])) {
    $editLocation = $location->getLocationById($_GET['id']);
}
?>
<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Charging Location</title>
</head>
<body>
    <h2>Edit Charging Location</h2>

    <form method="GET">
        <label>Select Location to Edit:</label>
        <select name="id" onchange="this.form.submit()">
            <option value="">--Choose--</option>
            <?php foreach ($locations as $loc): ?>
                <option value="<?= $loc['location_id'] ?>" <?= (isset($editLocation) && $editLocation['location_id'] == $loc['location_id']) ? 'selected' : '' ?>>
                    <?= $loc['description'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (isset($editLocation)): ?>
        <form method="POST">
            <input type="hidden" name="location_id" value="<?= $editLocation['location_id'] ?>">
            <label>Description:</label><br>
            <input type="text" name="description" value="<?= $editLocation['description'] ?>" required><br><br>

            <label>Number of Stations:</label><br>
            <input type="number" name="num_stations" value="<?= $editLocation['num_stations'] ?>" required><br><br>

            <label>Cost Per Hour ($):</label><br>
            <input type="number" name="cost_per_hour" value="<?= $editLocation['cost_per_hour'] ?>" step="0.01" required><br><br>

            <input type="submit" value="Update Location">
        </form>
        <p style="color:green"><?= $msg ?></p>
    <?php endif; ?>
</body>
</html>
<?php include '../includes/footer.php'; ?>