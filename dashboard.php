<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$is_admin = $_SESSION['is_admin'] ?? 0; // Check if the user is an admin

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <?php if ($is_admin == 1): ?>
        <p>You are an admin.</p>
        <!-- Display admin-only options here -->
    <?php else: ?>
        <p>Welcome, regular user.</p>
    <?php endif; ?>

    <form action="logout.php" method="post">
        <input type="submit" value="Sign Out">
    </form>
</body>
</html>