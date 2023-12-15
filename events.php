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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
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

        a {
            display: inline-block;
            margin-top: 20px;
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        div {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #000;
        }

        h2 {
            color: #001F3F;
        }

        h3 {
            color: #001F3F;
        }

        h4 {
            color: #001F3F;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>My Events</h1>
    <a href="event/create_event.php">Create New Event</a>
    <a href="dashboard.php">Back to Dashboard</a>

    <?php while ($event = $events->fetch_assoc()): ?>
        <div>
            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
            <p>Date: <?php echo htmlspecialchars($event['event_date']); ?>, Time: <?php echo htmlspecialchars($event['event_time']); ?></p>
            <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
            <p><?php echo htmlspecialchars($event['description']); ?></p>
            <a href="event/edit_event.php?id=<?php echo $event['id']; ?>">Edit Event</a>
            <a href="event/delete_event.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure?');">Delete Event</a>

            <h3>Guest List</h3>
            <?php
            $guests = $conn->query("SELECT * FROM guests WHERE event_id = " . $event['id']);
            while ($guest = $guests->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($guest['name']) . " - " . htmlspecialchars($guest['rsvp']) . " ";
                echo "<a href='guest/edit_guest.php?id=" . $guest['id'] . "'>Edit</a> ";
                echo "<a href='guest/delete_guest.php?id=" . $guest['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a></p>";

                echo "<h4>Tasks for " . htmlspecialchars($guest['name']) . "</h4>";
                $tasks = $conn->query("SELECT * FROM tasks WHERE guest_id = " . $guest['id']);
                while ($task = $tasks->fetch_assoc()) {
                    echo "<p>" . htmlspecialchars($task['task_description']) . " ";
                    echo "<a href='task/edit_task.php?id=" . $task['id'] . "'>Edit</a> ";
                    echo "<a href='task/delete_task.php?id=" . $task['id'] . "' onclick='return confirm(\"Are you sure to delete this task?\");'>Delete</a></p>";
                }
                echo "<a href='task/add_task.php?guest_id=" . $guest['id'] . "'>Add Task</a><br>";
            }
            echo "<a href='guest/add_guest.php?event_id=" . $event['id'] . "'>Add Guest</a>";
            ?>
        </div>
    <?php endwhile; ?>
</body>

</html>