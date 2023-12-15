<?php
session_start();
include '../../db_connect.php'; // Adjust path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

// Fetch users for the dropdown
$users = $conn->query("SELECT id, username FROM users");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id']; // User ID for the event
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (user_id, title, event_date, event_time, location, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $event_date, $event_time, $location, $description);
    $stmt->execute();

    header("Location: all_events.php"); // Redirect to all events page
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
            color: #000; /* Font color set to black */
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

        label {
            display: block;
            margin-bottom: 5px;
        }

        select, input, textarea {
            margin-bottom: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #808080; 
            color: #000; 
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
    <h1>Create Event</h1>
    <form action="create_event.php" method="post">
        <label for="user_id">User:</label>
        <select name="user_id" id="user_id">
            <?php while ($user = $users->fetch_assoc()): ?>
                <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="text" name="title" placeholder="Event Title" required><br>
        <input type="date" name="event_date" required><br>
        <input type="time" name="event_time" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="submit" value="Create Event">
    </form>
    <a href="all_events.php">Back to All Events</a>
</body>
</html>
