<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$events = $conn->query("SELECT * FROM events WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Events</title>
</head>
<body>
    <h1>My Events</h1>
    <a href="create_event.php">Create New Event</a>
    <a href="dashboard.php" style="margin-left: 20px;">Back to Dashboard</a>

    <?php while ($event = $events->fetch_assoc()): ?>
        <div style="margin-top: 20px; padding: 10px; border: 1px solid #000;">
            <h2><?php echo $event['title']; ?></h2>
            <p>Date: <?php echo $event['event_date']; ?>, Time: <?php echo $event['event_time']; ?></p>
            <p>Location: <?php echo $event['location']; ?></p>
            <p><?php echo $event['description']; ?></p>
            <a href="edit_event.php?id=<?php echo $event['id']; ?>">Edit Event</a>
            <a href="delete_event.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure?');">Delete Event</a>
            
            <h3>Guest List</h3>
            <?php
            $guests = $conn->query("SELECT * FROM guests WHERE event_id = " . $event['id']);
            while ($guest = $guests->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($guest['name']) . " - " . htmlspecialchars($guest['rsvp']) . "</p>";
                echo "<a href='edit_guest.php?id=" . $guest['id'] . "'>Edit</a> ";
                echo "<a href='delete_guest.php?id=" . $guest['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a></p>";
            }
            ?>
            <a href="add_guest.php?event_id=<?php echo $event['id']; ?>">Add Guest</a>
        </div>
    <?php endwhile; ?>
</body>
</html>
