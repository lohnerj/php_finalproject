<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM events WHERE user_id = $user_id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Events</title>
</head>
<body>
    <h1>My Events</h1>
    <a href="create_event.php">Create New Event</a>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <h2><?php echo $row['title']; ?></h2>
                <p>Date: <?php echo $row['event_date']; ?>, Time: <?php echo $row['event_time']; ?></p>
                <p>Location: <?php echo $row['location']; ?></p>
                <p><?php echo $row['description']; ?></p>
                <a href="edit_event.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_event.php?id=<?php echo $row['id']; ?>">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="dashboard.php" style="margin-bottom: 20px; display: inline-block;">Back to Dashboard</a>
</body>
</html>
