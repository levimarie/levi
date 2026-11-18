<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Collect the current and new email values
$current_email = $_POST['current_email'] ?? '';
$new_email = $_POST['new_email'] ?? '';
$confirm_email = $_POST['confirm_email'] ?? '';

// Step 1: Validate if new and confirm match
if ($new_email !== $confirm_email) {
    echo "<script>alert('New email and confirmation do not match.'); window.location.href='edit-email.php';</script>";
    exit();
}

// Step 2: Verify current email from DB
$check_sql = "SELECT email FROM users WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
$check_stmt->bind_result($db_email);
$check_stmt->fetch();
$check_stmt->close();

if ($current_email !== $db_email) {
    echo "<script>alert('Current email is incorrect.'); window.location.href='edit-email.php';</script>";
    exit();
}

// Step 3: Update email
$update_sql = "UPDATE users SET email = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $new_email, $user_id);

if ($update_stmt->execute()) {
    // Step 4: Insert notification
    $notif_msg = "You changed your email from $current_email to $new_email.";
    $notif_sql = "INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, NOW())";
    $notif_stmt = $conn->prepare($notif_sql);
    $notif_stmt->bind_param("is", $user_id, $notif_msg);
    $notif_stmt->execute();
    $notif_stmt->close();

    echo "<script>alert('Email updated successfully.'); window.location.href='settings.php';</script>";
} else {
    echo "<script>alert('Error updating email. Please try again.'); window.location.href='edit-email.php';</script>";
}

$update_stmt->close();
$conn->close();
?>