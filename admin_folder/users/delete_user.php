<?php
session_start();
include '../../db_connect.php'; // Adjust path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_GET['id'] ?? 0;

if ($user_id > 0) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

header("Location: all_users.php"); // Redirect to all users page
exit();
?>
