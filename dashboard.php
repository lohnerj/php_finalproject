<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$is_admin = $_SESSION['is_admin'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #000;
            background-color: #00B289;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #001F3F;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        p {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #808080;
            color: #fff;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <?php if ($is_admin == 1): ?>
        <p>You are an admin.</p>
        
        
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