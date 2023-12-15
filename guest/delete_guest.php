<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$guest_id = $_GET['id'] ?? 0;

if ($guest_id > 0) {
    $stmt = $conn->prepare("DELETE FROM guests WHERE id = ?");
    $stmt->bind_param("i", $guest_id);
    $stmt->execute();
}

header("Location: ../events.php"); // Redirect to events page
exit();
?>
