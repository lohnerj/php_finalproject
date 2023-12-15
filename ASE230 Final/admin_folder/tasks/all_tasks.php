<?php
session_start();
include '../../db_connect.php'; // Adjust the path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$tasks = $conn->query("SELECT tasks.*, guests.name FROM tasks JOIN guests ON tasks.guest_id = guests.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks</title>
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

        a {
            display: block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }

        div {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>All Tasks</h1>
    <a href="create_task.php">Create New Task</a>
    <?php while ($task = $tasks->fetch_assoc()): ?>
        <div>
            <p>Guest: <?php echo htmlspecialchars($task['name']); ?></p>
            <p>Task: <?php echo htmlspecialchars($task['task_description']); ?></p>
            - <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
            - <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
        </div>
    <?php endwhile; ?>
    <a href="../../dashboard.php">Back to Dashboard</a>
</body>
</html>
