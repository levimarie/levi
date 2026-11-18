<?php
require('fpdf/fpdf.php'); // Ensure you have this library

session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['quiz_id'])) {
    die("Access denied.");
}

$quiz_id = intval($_GET['quiz_id']);

// Fetch quiz
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

// Fetch questions
$qStmt = $conn->prepare("
    SELECT q.*
    FROM quiz_items qi
    JOIN questions q ON qi.question_id = q.id
    WHERE qi.quiz_id = ?
");
$qStmt->bind_param("i", $quiz_id);
$qStmt->execute();
$questions = $qStmt->get_result();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, ucfirst($quiz['title']), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);

// Header
$pdf->Cell(0, 10, 'Name: ______________________     Date: ______________________', 0, 1);
$pdf->Cell(0, 10, 'Grade & Section: ____________     Score: ____________________', 0, 1);
$pdf->Ln(5);

$isFilipinoTitle = stripos($quiz['title'], 'filipino') !== false;
$instructions = $isFilipinoTitle
    ? 'Basahin nang mabuti ang bawat tanong at bilugan ang titik ng tamang sagot.'
    : 'Read each question carefully and encircle the letter of the correct answer.';
$instructions_label = $isFilipinoTitle ? 'Panuto' : 'Instructions';
$pdf->MultiCell(0, 10, "$instructions_label: $instructions", 0, 1);
$pdf->Ln(2);

$isFilipino = stripos($quiz['subject'], 'filipino') !== false;
$label = $isFilipino ? 'Paglalarawan' : 'Description';
$pdf->MultiCell(0, 10, "$label: " . $quiz['description'], 0, 1);
$pdf->Ln(3);
// Questions
$i = 1;
while ($q = $questions->fetch_assoc()) {
    $pdf->MultiCell(0, 8, "{$i}. {$q['question_text']}", 0);
    $pdf->Cell(0, 8, "   A. {$q['option_a']}", 0, 1);
    $pdf->Cell(0, 8, "   B. {$q['option_b']}", 0, 1);
    $pdf->Cell(0, 8, "   C. {$q['option_c']}", 0, 1);
    $pdf->Cell(0, 8, "   D. {$q['option_d']}", 0, 1);
    $pdf->Ln(2);
    $i++;
}

// Output PDF
$pdf->Output("D", "quiz_{$quiz_id}.pdf"); // D for download
exit();
