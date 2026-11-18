<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$current_username = $_POST['current_username'] ?? '';
$new_username = $_POST['new_username'] ?? '';

// Step 1: Check for empty input
if (empty($new_username)) {
    die("New username cannot be empty.");
}

$successMessage = '';
if (isset($_GET['success']) && $_GET['success'] === 'username_changed') {
    $successMessage = "Username changed!";
}


// Step 2: Check if new username is already taken by another user
$checkSql = "SELECT id FROM users WHERE username = ? AND id != ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("si", $new_username, $user_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("Username already taken.");
}

// ✅ Step 3: Fetch the current username from the DB
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Step 4: Verify if current_username matches the database
if ($row && $row['username'] === $current_username) {
    // Update username
    $update = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("si", $new_username, $user_id);
    
    if ($stmt->execute()) {
        // Add notification
        $message = "You changed your username from $current_username to $new_username.";
        $notif_sql = "INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, NOW())";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("is", $user_id, $message);
        $notif_stmt->execute();

        // Redirect
        header("Location: settings.php?success=username_changed");
        exit();
    } else {
        echo "Error updating username.";
    }
} else {
    echo "Current username does not match.";
}
?>
