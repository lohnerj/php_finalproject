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
        
        <!-- Admin specific options -->
        <a href="admin_folder/users/all_users.php">View All Users</a><br>
        <a href="admin_folder/events/all_events.php">View All Events</a><br>
        <a href="admin_folder/guest_lists/all_guestlists.php">View All Guest Lists</a><br>
        <a href="admin_folder/tasks/all_tasks.php">View All Tasks</a><br>
    <?php else: ?>
        <p>Welcome, regular user.</p>
    <?php endif; ?>

    <a href="events.php">View Events</a>

    <form action="logout.php" method="post">
        <input type="submit" value="Sign Out">
    </form>
</body>
</html>