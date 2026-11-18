<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch profile picture
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

// Get quiz ID from URL
if (!isset($_GET['quiz_id'])) {
    die("Quiz ID not provided.");
}
$quiz_id = intval($_GET['quiz_id']);

// Fetch quiz from database
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();
if (!$quiz) {
    die("Quiz not found.");
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Quiz Page</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3399ff;
    }

    .top-bar {
      background-color: #2c2c2c;
      height: 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      color: white;
    }

    .quiz-box {
      background: white;
      border: 2px solid black;
      border-radius: 10px;
      padding: 20px;
      width: 70%;
      height: auto;
      margin: auto;
      min-height: 500px;
      margin-top: 30px;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px;
    }

    .download-btn {
      background-color: #ffdb4d;
      border: 2px solid #1e1e1e;
      padding: 15px 40px;
      font-size: 18px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .download-options {
      display: none;
      position: absolute;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      width: 200px;
      z-index: 5;
      left: 100%;
    }

    .download-options div {
      padding: 12px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .download-options div:last-child {
      border-bottom: none;
    }

    .download-options div:hover {
      background-color: #f2f2f2;
    }

    h2 {
      text-align: center;
    }

    .question {
      margin-bottom: 20px;
    }

    .left img {
      height: 130px;
    }

    .notif {
      height: 70px;
      width: 70px;
      border-radius: 50%;
      cursor: pointer;
    }

    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="top-bar">
  <div class="left"><img src="logo.png" height="60"></div>
  <div class="right" style="display: flex; align-items: center; gap: 30px;">
    <img class="notif" src="notif.png" onclick="window.location.href='notif.php'">
    <div class="user-profile" onclick="window.location.href='profile.php'">
      <img src="<?php echo htmlspecialchars($profilePic); ?>" />
    </div>
  </div>
</div>

<div class="container">
  <div class="quiz-box">
     <h2><?php echo ucfirst(htmlspecialchars($quiz['title'])); ?></h2>


   <!-- Header Fields -->
<div style="margin-bottom: 20px;">
  <table style="width: 100%; font-size: 16px;">
    <tr>
      <td style="width: 50%;"><strong>Name:</strong> ____________________________</td>
      <td style="text-align: right;"><strong>Date:</strong> ____________________________</td>
    </tr>
    <tr>
      <td><strong>Grade & Section:</strong> __________________</td>
      <td style="text-align: right;"><strong>Score:</strong> ___________________________</td>
    </tr>
  </table>
</div>


    <!-- Instructions -->
<div style="margin-bottom: 20px;">
  <strong>
    <?php 
      echo (stripos($quiz['title'], 'filipino') !== false) ? 'Panuto:' : 'Instructions:'; 
    ?>
  </strong>
  <?php
    if (stripos($quiz['title'], 'filipino') !== false) {
        echo "<p>Basahin nang mabuti ang bawat tanong at bilugan ang titik ng tamang sagot.</p>";
    } else {
        echo "<p>Read each question carefully and encircle the letter of the correct answer.</p>";
    }
  ?>
</div>


  <p><strong>
<?php 
    echo (stripos($quiz['subject'], 'filipino') !== false) 
        ? 'Paglalarawan' 
        : 'Description';
?>:</strong> 
<?php 
    echo htmlspecialchars($quiz['description']); 
?>
</p>

<br>


    <?php
    $i = 1;
    while ($q = $questions->fetch_assoc()) {
        echo "<div class='question'>";
        echo "<strong>{$i}. " . htmlspecialchars($q['question_text']) . "</strong><br/>";
        echo "A. " . htmlspecialchars($q['option_a']) . "<br/>";
        echo "B. " . htmlspecialchars($q['option_b']) . "<br/>";
        echo "C. " . htmlspecialchars($q['option_c']) . "<br/>";
        echo "D. " . htmlspecialchars($q['option_d']) . "<br/>";
        echo "</div>";
        $i++;
    }
    ?>
  </div>

  <div class="download-section" style="margin-top: 20px; position: relative;">
    <button class="download-btn" onclick="toggleDropdown()">
        <img src="iconk.png" width="24" /> Download
    </button>
    <div class="download-options" id="downloadOptions">
        <div style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Download As</div>
        <div onclick="download('pdf')">
            <img src="https://img.icons8.com/color/48/000000/pdf.png" width="24" /> PDF Standard
        </div>
        <div onclick="download('word')">
            <img src="https://img.icons8.com/color/48/000000/microsoft-word-2019--v2.png" width="24" /> Word Standard
        </div>
    </div>
</div>
&nbsp;
&nbsp;

<script>
function toggleDropdown() {
    const options = document.getElementById("downloadOptions");
    options.style.display = options.style.display === "block" ? "none" : "block";
}

function download(type) {
    const quizId = <?php echo json_encode($quiz_id); ?>;
    toggleDropdown();

    let downloadWindow;
    if (type === 'pdf') {
        downloadWindow = window.open(`download.php?quiz_id=${quizId}&file=${type}`, '_blank');
    } else if (type === 'word') {
        downloadWindow = window.open(`download_word.php?quiz_id=${quizId}&file=${type}`, '_blank');
    }

    // Wait a short delay before redirecting to dashboard
    setTimeout(() => {
        window.location.href = 'dashboard.php';
    }, 2000); // 2 seconds (adjust as needed)
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


</body>
</html>
