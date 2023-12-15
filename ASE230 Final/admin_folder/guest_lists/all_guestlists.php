<?php
session_start();
include '../../db_connect.php'; // Adjust the path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$guests = $conn->query("SELECT guests.*, events.title FROM guests JOIN events ON guests.event_id = events.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Guest Lists</title>
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

        a {
            display: block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }

        div {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
        }

        p {
            margin: 5px 0;
        }

        a.edit-link, a.delete-link {
            color: #001F3F; 
            text-decoration: none;
            margin-left: 5px;
        }

        a.edit-link:hover, a.delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>All Guest Lists</h1>
    <a href="create_guest.php">Create New Guest List</a>
    <?php while ($guest = $guests->fetch_assoc()): ?>
        <div>
            <p>Event: <?php echo htmlspecialchars($guest['title']); ?></p>
            <p>Name: <?php echo htmlspecialchars($guest['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($guest['email']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($guest['phone']); ?></p>
            <p>RSVP: <?php echo htmlspecialchars($guest['rsvp']); ?></p>
            - <a href="edit_guest.php?id=<?php echo $guest['id']; ?>" class="edit-link">Edit</a> <!-- Link to edit user -->
            - <a href="delete_guest.php?id=<?php echo $guest['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="delete-link">Delete</a>
        </div>
    <?php endwhile; ?>
    <a href="../../dashboard.php">Back to Dashboard</a>
</body>
</html>
