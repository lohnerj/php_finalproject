<?php
session_start();
include '../../db_connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$event_id = $_GET['id'] ?? 0;
$event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE events SET title = ?, event_date = ?, event_time = ?, location = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $event_date, $event_time, $location, $description, $event_id);
    $stmt->execute();

    header("Location: all_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
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

        form {
            margin-top: 20px;
        }

        input, textarea {
            margin-bottom: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #808080; 
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="edit_event.php?id=<?php echo $event_id; ?>" method="post">
        <input type="text" name="title" placeholder="Event Title" value="<?php echo $event['title']; ?>" required><br>
        <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required><br>
        <input type="time" name="event_time" value="<?php echo $event['event_time']; ?>" required><br>
        <input type="text" name="location" placeholder="Location" value="<?php echo $event['location']; ?>" required><br>
        <textarea name="description"><?php echo $event['description']; ?></textarea><br>
        <input type="submit" value="Update Event">
    </form>
    <a href="all_events.php">Back to All Events</a>
</body>
</html>
