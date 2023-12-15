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
<html>
<head>
    <title>All Events</title>
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
