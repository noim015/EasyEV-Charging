<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$location = new Location();
$locations = $location->getAvailableLocations();
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Locations with Available Stations</h2>
        <table border="1">
            <tr>
                <th>Description</th>
                <th>Available Stations</th>
                <th>Cost/Hour ($)</th>
            </tr>
            <?php foreach ($locations as $loc): ?>
            <tr>
                <td><?= $loc['description'] ?></td>
                <td><?= $loc['available'] ?></td>
                <td><?= $loc['cost_per_hour'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php include '../includes/footer.php'; ?>