<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get user data
$sql = "SELECT profile_pic, username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: settings.php");
    exit();
}

$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';
$username = $user['username'] ?? 'Unknown user';

// Perform delete immediately and show message
$notif_message = "User '{$username}' has deleted their account.";
$notif_sql = "INSERT INTO notifications (user_id, message, status) VALUES (?, ?, 'unread')";
$notif_stmt = $conn->prepare($notif_sql);
$system_user_id = 0;
$notif_stmt->bind_param("is", $system_user_id, $notif_message);
$notif_stmt->execute();

// Delete user
$delete_sql = "DELETE FROM users WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();

// Destroy session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account Deleted</title>
    <!-- Redirect after 5 seconds -->
    <meta http-equiv="refresh" content="5;url=login.php">
    <style>
        body {
            background-color: #3399ff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dialog-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            height: 300px;
            border: 2px solid black;
            font-size: 32px;
            font-weight: bold;
            color: #1e1e1e;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dialog-box">
        Account deleted!
    </div>
</body>
</html>