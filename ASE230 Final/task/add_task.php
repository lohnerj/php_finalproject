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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
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
    <h1>Add Task for Guest</h1>
    <form action="add_task.php" method="post">
        <input type="hidden" name="guest_id" value="<?php echo $guest_id; ?>">
        <textarea name="task_description" placeholder="Task Description" required></textarea><br>
        <input type="submit" value="Add Task">
    </form>
    <a href="../events.php">Back to Events</a>
</body>
</html>