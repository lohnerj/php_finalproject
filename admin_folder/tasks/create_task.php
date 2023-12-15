<?php
session_start();
include '../../db_connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_id = $_POST['guest_id'];
    $task_description = $_POST['task_description'];

    $stmt = $conn->prepare("INSERT INTO tasks (guest_id, task_description) VALUES (?, ?)");
    $stmt->bind_param("is", $guest_id, $task_description);
    $stmt->execute();

    header("Location: all_tasks.php"); // Redirect to all tasks page
    exit();
}

$guests = $conn->query("SELECT * FROM guests");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
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

        select, textarea {
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
            display: block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Create Task</h1>
    <form action="create_task.php" method="post">
        <select name="guest_id">
            <?php while ($guest = $guests->fetch_assoc()): ?>
                <option value="<?php echo $guest['id']; ?>"><?php echo htmlspecialchars($guest['name']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <textarea name="task_description" placeholder="Task Description" required></textarea><br>
        <input type="submit" value="Create Task">
    </form>
    <a href="all_tasks.php">Back to All Tasks</a>
</body>
</html>