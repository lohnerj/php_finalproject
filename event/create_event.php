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

    header("Location: ../events.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
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
    <h1>Create Event</h1>
    <form action="create_event.php" method="post">
        <input type="text" name="title" placeholder="Event Title" required><br>
        <input type="date" name="event_date" required><br>
        <input type="time" name="event_time" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="submit" value="Create Event">
    </form>
    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>