<?php
session_start();
include '../../db_connect.php'; // Adjust the path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

// Fetch all events for the dropdown
$events = $conn->query("SELECT id, title FROM events");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rsvp = $_POST['rsvp'];

    $stmt = $conn->prepare("INSERT INTO guests (event_id, name, email, phone, rsvp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $event_id, $name, $email, $phone, $rsvp);
    $stmt->execute();

    header("Location: all_guestlists.php"); // Redirect to all_guestlists page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Guest</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #000;
            background-color: #00B289;
        }

        h1 {
            background-color: #001F3F; 
            color: #fff;
            padding: 20px 0;
        }

        form {
            margin-top: 20px;
        }

        select, input, textarea {
            margin-bottom: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #808080; 
            color: #000; 
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
    <h1>Add Guest</h1>
    <form action="create_guest.php" method="post">
        <select name="event_id">
            <?php while ($event = $events->fetch_assoc()): ?>
                <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
            <?php endwhile; ?>
        </select><br>
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
    <a href="all_guestlists.php">Back to Guest Lists</a>
</body>
</html>