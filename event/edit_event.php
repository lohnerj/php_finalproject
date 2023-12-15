<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE events SET title = ?, event_date = ?, event_time = ?, location = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $event_date, $event_time, $location, $description, $event_id);
    $stmt->execute();

    header("Location: ../events.php"); 
    exit();
}


$event_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="edit_event.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
        <input type="text" name="title" placeholder="Event Title" required value="<?php echo $event['title']; ?>"><br>
        <input type="date" name="event_date" required value="<?php echo $event['event_date']; ?>"><br>
        <input type="time" name="event_time" required value="<?php echo $event['event_time']; ?>"><br>
        <input type="text" name="location" placeholder="Location" required value="<?php echo $event['location']; ?>"><br>
        <textarea name="description" placeholder="Description"><?php echo $event['description']; ?></textarea><br>
        <input type="submit" value="Update Event">
    </form>
    <a href="../dashboard.php" style="margin-bottom: 20px; display: inline-block;">Back to Dashboard</a>
</body>
</html>
