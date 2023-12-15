<?php
session_start();
include '../../db_connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$task_id = $_GET['id'] ?? 0;

if ($task_id > 0) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
}

header("Location: all_tasks.php"); // Redirect to all tasks page
exit();
?>
