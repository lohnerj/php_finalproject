<?php
session_start();
include '../../db_connect.php'; // Adjust path as needed

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    // Only update the password if a new one is provided
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : NULL;
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    if ($password) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("ssii", $username, $password, $is_admin, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("sii", $username, $is_admin, $user_id);
    }
    $stmt->execute();

    header("Location: all_users.php"); // Redirect to all users page
    exit();
}

$user_id = $_GET['id'] ?? 0;
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit_user.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($user['username']); ?>"><br>
        <input type="password" name="password" placeholder="New Password"><br>
        <label>
            <input type="checkbox" name="is_admin" <?php if ($user['is_admin']) echo "checked"; ?>> Is Admin
        </label><br>
        <input type="submit" value="Update User">
    </form>
    <a href="all_users.php">Back to All Users</a>
</body>
</html>
