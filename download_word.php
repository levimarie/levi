<?php
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

// Start output buffering
ob_start();
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=quiz_{$quiz_id}.doc");

echo "<html><body>";
echo "<h2>" . ucfirst($quiz['title']) . "</h2>";
echo "<p><strong>Name:</strong> ______________________ <strong>Date:</strong> ______________________</p>";
echo "<p><strong>Grade & Section:</strong> ____________ <strong>Score:</strong> ____________________</p>";

$instructions = stripos($quiz['title'], 'filipino') !== false 
    ? 'Basahin nang mabuti ang bawat tanong at bilugan ang titik ng tamang sagot.'
    : 'Read each question carefully and encircle the letter of the correct answer.';
$instructions_label = stripos($quiz['title'], 'filipino') !== false ? 'Panuto' : 'Instructions';
echo "<p><strong>$instructions_label:</strong> $instructions</p>";

$description_label = stripos($quiz['title'], 'filipino') !== false ? 'Paglalarawan' : 'Description';
echo "<p><strong>$description_label:</strong> " . htmlspecialchars($quiz['description']) . "</p><br>";


$i = 1;
while ($q = $questions->fetch_assoc()) {
    echo "<p><strong>$i. " . htmlspecialchars($q['question_text']) . "</strong><br/>";
    echo "A. " . htmlspecialchars($q['option_a']) . "<br/>";
    echo "B. " . htmlspecialchars($q['option_b']) . "<br/>";
    echo "C. " . htmlspecialchars($q['option_c']) . "<br/>";
    echo "D. " . htmlspecialchars($q['option_d']) . "</p><br/>";
    $i++;
}
echo "</body></html>";

// Send the file
ob_end_flush();
?>
 <iframe id="hiddenDownloader" style="display:none;"></iframe>

<script>
function toggleDropdown() {
    const options = document.getElementById("downloadOptions");
    options.style.display = options.style.display === "block" ? "none" : "block";
}

function download(type) {
    const quizId = <?php echo json_encode($quiz_id); ?>;
    toggleDropdown();

    if (type === 'pdf') {
        window.location.href = `download.php?quiz_id=${quizId}&file=${type}`;
    } else if (type === 'word') {
        // Start the download invisibly
        document.getElementById("hiddenDownloader").src = `download_word.php?quiz_id=${quizId}&file=${type}`;

        // Redirect to dashboard after a short wait
        setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 100); // 2 seconds delay
    }
}

// Close dropdown if clicked outside
window.onclick = function(event) {
    const btn = document.querySelector(".download-btn");
    const options = document.getElementById("downloadOptions");
    if (!btn.contains(event.target)) {
        options.style.display = "none";
    }
};
</script>

