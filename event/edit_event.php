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
            color: #fff;
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

        form {
            margin-top: 20px;
            max-width: 400px;
        }

        input, textarea {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #808080;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #fff;
            text-decoration: none;
        }
    </style>
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
    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>



