<?php
session_start();
header("Content-Type: application/json");
include 'db.php';

try {
    if (!isset($_SESSION["user_id"])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized: User not logged in."]);
        exit();
    }

    $user_id = $_SESSION["user_id"];

    $sql = "SELECT subject, num_questions, points_per_item FROM quizzes WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Failed to prepare SQL statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $quizzes = [];

    while ($row = $result->fetch_assoc()) {
        $row['total_score'] = $row['num_questions'] * $row['points_per_item'];
        $quizzes[] = $row;
    }

    echo json_encode([
        "user_id" => $user_id,
        "quizzes" => $quizzes
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Server error: " . $e->getMessage()]);
}
?>

