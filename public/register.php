<?php
require_once '../classes/User.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $type = $_POST['type'] ?? '';

    if ($name && $phone && $email && $password && ($type == 'user' || $type == 'admin')) {
        $user = new User();
        if ($user->register($name, $phone, $email, $password, $type)) {
            $msg = "Registration successful. <a href='login.php'>Login here</a>";
        } else {
            $msg = "Error: Email might already exist.";
        }
    } else {
        $msg = "Please fill all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - EasyEV-Charging</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>User Type:</label><br>
        <select name="type" required>
            <option value="">--Select--</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>

    <p style="color:green"><?= $msg ?></p>
</body>
</html>
