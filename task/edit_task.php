<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $task_description = $_POST['task_description'];

    $stmt = $conn->prepare("UPDATE tasks SET task_description = ? WHERE id = ?");
    $stmt->bind_param("si", $task_description, $task_id);
    $stmt->execute();

    header("Location: ../events.php"); 
    exit();
}

$task_id = $_GET['id'] ?? 0;
$task = $conn->query("SELECT * FROM tasks WHERE id = $task_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
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

        textarea {
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
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Edit Task</h1>
    <form action="edit_task.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
        <textarea name="task_description" required><?php echo htmlspecialchars($task['task_description']); ?></textarea><br>
        <input type="submit" value="Update Task">
    </form>
    <a href="../events.php">Back to Events</a>
</body>
</html>