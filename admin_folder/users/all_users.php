<?php
session_start();
include '../../db_connect.php'; // Adjust path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
</head>
<body>
    <h1>All Users</h1>
    <a href="create_user.php">Create New User</a> <!-- Link to create a new user -->
    <?php while ($user = $users->fetch_assoc()): ?>
        <div>
            <p>
                <?php echo htmlspecialchars($user['username']); ?>
                <?php if ($user['is_admin']) echo " (Admin)"; ?>
                - <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> <!-- Link to edit user -->
                - <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a> <!-- Link to delete user -->
            </p>
        </div>
    <?php endwhile; ?>
    <a href="../../dashboard.php">Back to Dashboard</a>
</body>
</html>
