<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

$title = $_POST['quizTitle'];
$desc = $_POST['quizDesc'];
$numQuestions = (int) $_POST['numQuestions'];
$points = (int) $_POST['pointsPerItem'];
$qtype = $_POST['qtype'];
$subject = strtolower(trim($title));

$isFilipino = ($subject === 'filipino');


$allowedSubjects = ['filipino', 'english', 'science'];
if (!in_array($subject, $allowedSubjects)) {
    die("Invalid subject. Allowed: Filipino, English, Science.");

    
}

$stmt = $conn->prepare("INSERT INTO quizzes (user_id, title, description, subject, num_questions, points_per_item) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssii", $user_id, $title, $desc, $subject, $numQuestions, $points);
$stmt->execute();
$quiz_id = $stmt->insert_id;

$notifMsg = "You have successfully created the quiz: $title";
$createdAt = date("Y-m-d H:i:s");
$notifStmt = $conn->prepare("INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, ?)");
$notifStmt->bind_param("iss", $user_id, $notifMsg, $createdAt);
$notifStmt->execute();


$stmt = $conn->prepare("SELECT * FROM questions WHERE subject = ? ORDER BY RAND() LIMIT ?");
$stmt->bind_param("si", $subject, $numQuestions);
$stmt->execute();
$questions = $stmt->get_result();

$insert = $conn->prepare("INSERT INTO quiz_items (quiz_id, question_id) VALUES (?, ?)");
$questionData = [];
while ($q = $questions->fetch_assoc()) {
    $insert->bind_param("ii", $quiz_id, $q['id']);
    $insert->execute();
    $questionData[] = $q;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Preview Quiz</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #3399ff;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .top-bar {
      background-color: #2c2c2c;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      height: 80px;
      width: 100%;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .left-section img {
      height: 130px;
    }

    .right-section {
      display: flex;
      align-items: center;
      gap: 26px;
      font-size: 40px;
      cursor: pointer;
      margin-right: 65px;
    }

    .notification-icon {
      width: 70px;
      height: 70px;
      cursor: pointer;
      border-radius: 50%;
    }

    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
    }

    .quiz-box {
      background-color: white;
      border:2px solid black;
      padding: 40px;
      margin-top: 120px;
      width: 80%;
      max-width: 900px;
      border-radius: 12px;
      text-align: left;
    }

    .quiz-title {
      text-align: center;
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .quiz-desc {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .question {
      margin-bottom: 15px;
      font-size: 18px;
    }

    .actions {
      margin-top: 30px;
      display: flex;
      justify-content: center;
      gap: 30px;
    }

    .btn {
      padding: 12px 40px;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 8px;
      border: 2px solid   #1e1e1e;
      text-decoration: none;
    }

    .btn.save {
      background: #ffdb4d;
      color: black;
    }

    .btn.cancel {
      background: black;
      color: white;
    }

    @media (max-width: 768px) {
      .quiz-box {
        padding: 20px;
      }

      .btn {
        width: 100%;
      }

      .actions {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <div class="left-section">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="right-section">
      <img src="notif.png" class="notification-icon" onclick="window.location.href='notif.php'">
      <div class="user-profile" onclick="window.location.href='profile.php'">
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" />
      </div>
    </div>
  </div>

  <!-- All content now inside the white quiz box -->
  <div class="quiz-box">
    <div class="quiz-title"><?php echo htmlspecialchars($title); ?> </div>

   <div class="quiz-desc">
  <strong><?php echo $isFilipino ? 'Paglalarawan' : 'Description'; ?>:</strong> 
  <?php echo htmlspecialchars($desc); ?>
</div>

    <?php foreach ($questionData as $i => $q): ?>
      <div class="question">
        <strong><?php echo ($i+1) . ". " . htmlspecialchars($q['question_text']); ?></strong><br>
        A. <?php echo htmlspecialchars($q['option_a']); ?><br>
        B. <?php echo htmlspecialchars($q['option_b']); ?><br>
        C. <?php echo htmlspecialchars($q['option_c']); ?><br>
        D. <?php echo htmlspecialchars($q['option_d']); ?><br>
        <br>
        <br>
        <strong><?php echo $isFilipino ? 'Wastong Sagot' : 'Correct Answer'; ?>:</strong>
      <?php echo htmlspecialchars($q['correct_answer']); ?><br>
    </div>
  <?php endforeach; ?>
  </div>

  <div class="actions">
    <a href="createquiz.php" class="btn cancel">Cancel</a>
    <a href="downloadquiz.php?quiz_id=<?php echo $quiz_id; ?>" class="btn save">Save</a>
  </div>

</body>
</html>
