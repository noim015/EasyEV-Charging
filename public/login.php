<?php
session_start();
require_once '../classes/User.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $userObj = new User();
        $user = $userObj->login($email, $password);

        if ($user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'type' => $user['type']
            ];
            // Redirect to role-specific dashboard
            if ($user['type'] === 'admin') {
                header('Location: dashboard_admin.php');
            } else {
                header('Location: dashboard_user.php');
            }
            exit;
        } else {
            $msg = "Invalid login credentials.";
        }
    } else {
        $msg = "Email and password are required.";
    }
}
?>
<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - EasyEV-Charging</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <p style="color:red"><?= $msg ?></p>
</body>
</html>
<?php include '../includes/footer.php'; ?>