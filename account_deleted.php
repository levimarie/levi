<?php
session_start();
include 'db.php';

// Assuming user is logged in and you have their ID
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Destroy session
    session_unset();
    session_destroy();

    // Redirect after 3 seconds
    header("refresh:3;url=login.php");
} else {
    header("Location: login.php");
    exit;
}
?>
