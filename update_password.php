<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$current_password = $_SESSION["temp_current_password"];
$new_password = $_SESSION["temp_new_password"];

$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $db_password = $row["password"];

    if (!password_verify($current_password, $db_password)) {
        echo "<script>alert('Incorrect current password.'); window.location.href='changepassword.php';</script>";
        exit();
    }

    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE users SET password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_password_hash, $user_id);

    if ($update_stmt->execute()) {
        // ✅ INSERT notification
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $message = "You have successfully changed your password.";
        $notif_stmt->bind_param("is", $user_id, $message);
        $notif_stmt->execute();
        $notif_stmt->close();

        // Clean up temporary session variables
        unset($_SESSION["temp_current_password"]);
        unset($_SESSION["temp_new_password"]);
        unset($_SESSION["temp_confirm_password"]);

        echo "<script>alert('Password updated successfully.'); window.location.href='settings.php';</script>";
    } else {
        echo "<script>alert('Failed to update password.'); window.location.href='changepassword.php';</script>";
    }
} else {
    echo "<script>alert('User not found.'); window.location.href='changepassword.php';</script>";
}
?>