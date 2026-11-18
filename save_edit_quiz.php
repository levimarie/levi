<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"]; // current user ID from session
$quiz_id = (int) $_POST['quiz_id'];
$title = trim($_POST['quizTitle']);
$desc = trim($_POST['quizDesc']);

// Update quiz title and description
$stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ? WHERE id = ?");
$stmt->bind_param("ssi", $title, $desc, $quiz_id);
$stmt->execute();

// Update each question
if (!empty($_POST['questions'])) {
    foreach ($_POST['questions'] as $question_id => $data) {
        $text = trim($data['text']);
        $a = trim($data['a']);
        $b = trim($data['b']);
        $c = trim($data['c']);
        $d = trim($data['d']);
        $answer = strtoupper(trim($data['answer']));

        $qStmt = $conn->prepare("UPDATE questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_answer = ? WHERE id = ?");
        $qStmt->bind_param("ssssssi", $text, $a, $b, $c, $d, $answer, $question_id);
        $qStmt->execute();
    }
}

// Insert notification after update
$notifMessage = "Quiz \"$title\" was updated.";

$notifStmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
$notifStmt->bind_param("is", $user_id, $notifMessage);
$notifStmt->execute();

// Redirect to download quiz page
header("Location: downloadquiz.php?quiz_id=" . $quiz_id);
exit();
?>