<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (user_id, title, event_date, event_time, location, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $event_date, $event_time, $location, $description);
    $stmt->execute();

    header("Location: ../events.php"); // Redirect to events page
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
    <h1>Create Event</h1>
    <form action="create_event.php" method="post">
        <input type="text" name="title" placeholder="Event Title" required><br>
        <input type="date" name="event_date" required><br>
        <input type="time" name="event_time" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="submit" value="Create Event">
    </form>
    <a href="../dashboard.php" style="margin-bottom: 20px; display: inline-block;">Back to Dashboard</a>
</body>
</html>
