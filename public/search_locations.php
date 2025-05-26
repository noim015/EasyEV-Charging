<?php
require_once '../init.php';
require_once '../classes/Location.php';

if (!isAdmin() && !isUser()) {
    echo "Unauthorized access.";
    exit;
}

$msg = '';
$locations = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search_term'] ?? '';

    // Validate input (ensure it's safe and not empty)
    if (!empty($searchTerm)) {
        // Sanitize input to avoid SQL injection
        $searchTerm = htmlspecialchars($searchTerm);
        
        $location = new Location();
        $locations = $location->searchLocations($searchTerm);
        
        if (empty($locations)) {
            $msg = "No results found.";
        }
    } else {
        $msg = "Please enter a search term.";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Search Charging Locations</h2>

    <form method="POST">
        <label>Search by LocationID or Description:</label><br>
        <input type="text" name="search_term" required><br><br>
        <input type="submit" value="Search">
    </form>

    <p style="color:red"><?= $msg ?></p>

    <?php if (!empty($locations)): ?>
        <table border="1">
            <tr>
                <th>LocationID</th>
                <th>Description</th>
                <th>Available Stations</th>
                <th>Cost per Hour</th>
            </tr>
            <?php foreach ($locations as $loc): ?>
                <tr>
                    <td><?= $loc['location_id'] ?></td>
                    <td><?= $loc['description'] ?></td>
                    <td><?= $loc['available'] ?></td>
                    <td><?= $loc['cost_per_hour'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
    
<?php include '../includes/footer.php'; ?>