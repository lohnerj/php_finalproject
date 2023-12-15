<?php
session_start();
include '../../db_connect.php'; // Adjust the path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$guest_id = $_GET['id'] ?? 0;

if ($guest_id > 0) {
    $stmt = $conn->prepare("DELETE FROM guests WHERE id = ?");
    $stmt->bind_param("i", $guest_id);
    $stmt->execute();
}

header("Location: all_guestlists.php"); // Redirect to all_guestlists page
exit();
?>
