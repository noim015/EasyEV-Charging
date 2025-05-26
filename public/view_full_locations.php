<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$location = new Location();
$conn = (new Database())->connect();

$sql = "
    SELECT l.description, l.num_stations, COALESCE(used.count, 0) as used
    FROM charging_locations l
    LEFT JOIN (
        SELECT location_id, COUNT(*) AS count 
        FROM checkins 
        WHERE checkout_time IS NULL 
        GROUP BY location_id
    ) used ON l.location_id = used.location_id
    WHERE l.num_stations = COALESCE(used.count, 0)
";
$result = $conn->query($sql);
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Locations That Are Full</h2>
        <table border="1">
            <tr>
                <th>Description</th>
                <th>Total Stations</th>
                <th>Occupied</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['description'] ?></td>
                <td><?= $row['num_stations'] ?></td>
                <td><?= $row['used'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

<?php include '../includes/footer.php'; ?>