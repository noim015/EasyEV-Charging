<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$location = new Location();
$locations = $location->getAllLocations();
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>All Charging Locations</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Total Stations</th>
                <th>Cost/Hour ($)</th>
            </tr>
            <?php foreach ($locations as $loc): ?>
            <tr>
                <td><?= $loc['location_id'] ?></td>
                <td><?= $loc['description'] ?></td>
                <td><?= $loc['num_stations'] ?></td>
                <td><?= $loc['cost_per_hour'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php include '../includes/footer.php'; ?>