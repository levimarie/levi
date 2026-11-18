<?php
// reset_password.php
session_start();
include 'db.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgotpassword.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='forgotpassword1.php';</script>";
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];

    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        unset($_SESSION['reset_email']);
        echo "<script>alert('Password updated successfully. Please log in.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error updating password.'); window.location.href='forgotpassword1.php';</script>";
    }
}
?>
