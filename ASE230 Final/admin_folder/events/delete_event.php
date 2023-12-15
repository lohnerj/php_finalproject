<?php
session_start();
include '../../db_connect.php'; // Adjust path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$event_id = $_GET['id'] ?? 0;

if ($event_id > 0) {
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
}

header("Location: all_events.php"); // Redirect to all events page
exit();
?>
