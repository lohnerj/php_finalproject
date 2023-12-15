<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_id = $_POST['guest_id'];
    $task_description = $_POST['task_description'];

    $stmt = $conn->prepare("INSERT INTO tasks (guest_id, task_description) VALUES (?, ?)");
    $stmt->bind_param("is", $guest_id, $task_description);
    $stmt->execute();

    header("Location: ../events.php"); 
    exit();
}

$guest_id = $_GET['guest_id'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>
    <h1>Add Task for Guest</h1>
    <form action="add_task.php" method="post">
        <input type="hidden" name="guest_id" value="<?php echo $guest_id; ?>">
        <textarea name="task_description" placeholder="Task Description" required></textarea><br>
        <input type="submit" value="Add Task">
    </form>
    <a href="../events.php">Back to Events</a>
</body>
</html>
