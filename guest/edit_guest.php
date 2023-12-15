<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_id = $_POST['guest_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rsvp = $_POST['rsvp'];

    $stmt = $conn->prepare("UPDATE guests SET name = ?, email = ?, phone = ?, rsvp = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $rsvp, $guest_id);
    $stmt->execute();

    header("Location: ../events.php"); // Redirect to events page
    exit();
}

$guest_id = $_GET['id'] ?? 0;
$guest = $conn->query("SELECT * FROM guests WHERE id = $guest_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Guest</title>
</head>
<body>
    <h1>Edit Guest</h1>
    <form action="edit_guest.php" method="post">
        <input type="hidden" name="guest_id" value="<?php echo $guest_id; ?>">
        <input type="text" name="name" placeholder="Name" required value="<?php echo $guest['name']; ?>"><br>
        <input type="email" name="email" placeholder="Email" value="<?php echo $guest['email']; ?>"><br>
        <input type="text" name="phone" placeholder="Phone Number" value="<?php echo $guest['phone']; ?>"><br>
        <select name="rsvp">
            <option value="Pending" <?php echo $guest['rsvp'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Confirmed" <?php echo $guest['rsvp'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
            <option value="Declined" <?php echo $guest['rsvp'] == 'Declined' ? 'selected' : ''; ?>>Declined</option>
        </select><br>
        <input type="submit" value="Update Guest">
    </form>
    <a href="../events.php">Back to Events</a>
</body>
</html>
