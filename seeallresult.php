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
?>
<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if (!isset($_GET['quiz_id'])) {
    echo "No quiz ID provided.";
    exit();
}

$quiz_id = (int)$_GET['quiz_id'];

$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quizResult = $stmt->get_result();

if ($quizResult->num_rows === 0) {
    echo "Quiz not found.";
    exit();
}

$quiz = $quizResult->fetch_assoc();
$totalScore = $quiz['num_questions'] * $quiz['points_per_item'];

// Fetch questions
$stmt = $conn->prepare("
    SELECT q.id, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_answer
    FROM quiz_items qi
    JOIN questions q ON qi.question_id = q.id
    WHERE qi.quiz_id = ?
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questionsResult = $stmt->get_result();

$questions = [];
while ($row = $questionsResult->fetch_assoc()) {
    $questions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3399ff;
            padding: 30px;
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


        .result-box {
            background: white;
            padding: 100px;
            border-radius: 10px;
            max-width: 1000px;
            margin: 0 auto;
            border: 2px solid black;
            margin-top: 140px;
        }

         h2 {
            text-align: left;
            color: #2c2c2c;
        }
        h1{
          text-align: center;
            color: #2c2c2c;
        
        }
       


        .quiz-info {
          margin-bottom: 30px;
          font-size: 20px;
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
        }


        .question, .answer {
            margin-bottom: 30px;
            padding:20px;
            background-color: #f0f8ff;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 20px;
        }

        .correct-answer {
            font-weight: bold;
            color: green;
        
        }
        .addquiz-btn {
      display: block;
      margin: 50px auto 30px;
      background-color: #f1c40f;
      color: black;
      border: 2px solid black;
      padding: 14px 32px;
      font-size: 30px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      width: 360px;
    }

    .addquiz:hover {
      background-color: #e0b807;
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


<div class="result-box">
   <h1><?php echo ucfirst(htmlspecialchars($quiz['title'])); ?></h1>

    <?php
$isFilipino = isset($quiz['subject']) && stripos($quiz['subject'], 'filipino') !== false;
$descLabel = $isFilipino ? 'Paglalarawan' : 'Description';
?>
<div class="quiz-info">
    <p><strong><?php echo $descLabel; ?>:</strong> <?php echo htmlspecialchars($quiz['description']); ?></p>
    <p><strong>Total Score:</strong> <?php echo $totalScore; ?> points</p>
</div>


    <h2><?php echo $isFilipino ? 'Mga Tanong' : 'Questions'; ?></h2>
    <?php $count = 1; foreach ($questions as $q): ?>
        <div class="question">
            <strong><?php echo $count . ". " . htmlspecialchars($q['question_text']); ?></strong><br>
            A. <?php echo htmlspecialchars($q['option_a']); ?><br>
            B. <?php echo htmlspecialchars($q['option_b']); ?><br>
            C. <?php echo htmlspecialchars($q['option_c']); ?><br>
            D. <?php echo htmlspecialchars($q['option_d']); ?><br>
        </div>
    <?php $count++; endforeach; ?>
<h2><?php echo $isFilipino ? 'Susi ng Mga Sagot' : 'Answer Key'; ?></h2>

    <?php $count = 1; foreach ($questions as $q): ?>
        <div class="answer">
            <strong><?php echo $isFilipino ? 'Wastong Sagot' : 'Correct Answer'; ?>:</strong>
      <?php echo htmlspecialchars($q['correct_answer']); ?><br>
        </div>
    <?php endforeach; ?>
</div>
    

<!-- ✅ Create Button Always at Bottom -->
  <div style="text-align: center;">
    <button class="addquiz-btn" onclick="window.location.href='createquiz.php'">➕ Create Quiz</button>
  </div>

</body>
</html>
