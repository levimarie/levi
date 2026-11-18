<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
header("Content-Type: application/json");
require 'db.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION["user_id"];

// Get user email
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || empty($user['email'])) {
    echo json_encode(["error" => "User email not found."]);
    exit();
}

$email = $user['email'];

// Get notifications
$stmt = $conn->prepare("SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$notif_result = $stmt->get_result();

if ($notif_result->num_rows === 0) {
    echo json_encode(["message" => "No notifications to send."]);
    exit();
}

// Prepare email body
$body = "Here are your latest notifications from Quizify:\n\n";
while ($row = $notif_result->fetch_assoc()) {
    $body .= "- " . $row['message'] . " (" . date("F j, Y g:i A", strtotime($row['created_at'])) . ")\n";
}

// Set up PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Gmail SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'yourgmail@gmail.com';  // Your Gmail
    $mail->Password = 'your-app-password';    // App password (not Gmail login)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email content
    $mail->setFrom('yourgmail@gmail.com', 'Quizify System');
    $mail->addAddress($email);
    $mail->Subject = 'Your Quizify Notifications';
    $mail->Body = $body;

    $mail->send();
    echo json_encode(["success" => "Notifications successfully sent to $email"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Mailer Error: " . $mail->ErrorInfo]);
}
