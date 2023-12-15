<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rsvp = $_POST['rsvp'];

    $stmt = $conn->prepare("INSERT INTO guests (event_id, name, email, phone, rsvp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $event_id, $name, $email, $phone, $rsvp);
    $stmt->execute();

    header("Location: events.php"); // Redirect to events page
    exit();
}

$event_id = $_GET['event_id'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Guest</title>
</head>
<body>
    <h1>Add Guest</h1>
    <form action="add_guest.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="phone" placeholder="Phone Number"><br>
        <select name="rsvp">
            <option value="Pending">Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Declined">Declined</option>
        </select><br>
        <input type="submit" value="Add Guest">
    </form>
    <a href="events.php">Back to Events</a>
</body>
</html>
