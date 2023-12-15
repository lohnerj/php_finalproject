<?php
session_start();
include '../../db_connect.php'; // Adjust the path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$events = $conn->query("SELECT events.*, users.username FROM events JOIN users ON events.user_id = users.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #000; 
            background-color: #00B289; 
        }

        h1 {
            background-color: #001F3F; 
            color: #fff;
            padding: 20px 0;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #fff; 
            text-decoration: none;
        }

        div {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
        }

        h2 {
            color: #001F3F; 
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>All Events</h1>
    <a href="create_event.php">Create New Event</a> <!-- Button to create a new event -->
    <?php while ($event = $events->fetch_assoc()): ?>
        <div>
            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
            <p>Organized by: <?php echo htmlspecialchars($event['username']); ?></p>
            <p>Date: <?php echo htmlspecialchars($event['event_date']); ?>, Time: <?php echo htmlspecialchars($event['event_time']); ?></p>
            <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
            <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
            <a href="edit_event.php?id=<?php echo $event['id']; ?>">Edit Event</a> <!-- Button to edit event -->
            <a href="delete_event.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure?');">Delete Event</a> <!-- Button to delete event -->
        </div>
    <?php endwhile; ?>
    <a href="../../dashboard.php">Back to Dashboard</a>
</body>
</html>