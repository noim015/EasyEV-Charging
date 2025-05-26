<?php
require_once '../init.php';
require_once '../config/db.php';

if (!isAdmin()) {
    echo "Unauthorized access.";
    exit;
}

$conn = (new Database())->connect();
$result = $conn->query("SELECT * FROM users");
?>
<?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Registered Users</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Type</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['type'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

<?php include '../includes/footer.php'; ?>