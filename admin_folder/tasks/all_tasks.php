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
<html>
<head>
    <title>All Tasks</title>
</head>
<body>
    <h1>All Tasks</h1>
    <a href="create_task.php">Create New Task</a>
    <?php while ($task = $tasks->fetch_assoc()): ?>
        <div>
            <p>Guest: <?php echo htmlspecialchars($task['name']); ?></p>
            <p>Task: <?php echo htmlspecialchars($task['task_description']); ?></p>
            - <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a> <!-- Link to edit user -->
            - <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
        </div>
    <?php endwhile; ?>
    <a href="../../dashboard.php">Back to Dashboard</a>
</body>
</html>
