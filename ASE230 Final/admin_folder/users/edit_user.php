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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #fff;
            background-color: #00B289;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #001F3F;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        form {
            margin-top: 20px;
            max-width: 400px;
        }

        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #808080;
            color: #fff;
            cursor: pointer;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #fff;
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
