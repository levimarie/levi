<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;

// Fetch profile picture
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

// Fetch quiz
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quizResult = $stmt->get_result();
$quiz = $quizResult->fetch_assoc();
if (!$quiz) die("Quiz not found.");

// Fetch questions
$stmt = $conn->prepare("
    SELECT q.*
    FROM quiz_items qi
    JOIN questions q ON qi.question_id = q.id
    WHERE qi.quiz_id = ?
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questions = $stmt->get_result();
$questionData = [];
while ($q = $questions->fetch_assoc()) {
    $questionData[] = $q;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Quiz</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3399ff;
    }
    .top-bar {
      background-color: #2c2c2c;
      height: 80px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      color: white;
    }
    .edit {
      color: white;
      font-size: 30px;
    }
    .top-bar .left img {
      height: 130px;
    }
    .top-bar .right {
      display: flex;
      gap: 30px;
      align-items: center;
      margin-right: 50px;
    }
    .notif {
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
      cursor: pointer;
      margin-bottom: 5px;
    }
    .quiz-content {
      width: 90%;
      max-width: 1200px;
      margin: 40px auto;
      color: black;
    }
    .quiz-content h2 {
      text-align: center;
      font-size: 36px;
      color: black;
      margin-bottom: 30px;
    }
    .empty-box {
      background-color: white;
      border-radius: 12px;
      padding: 40px;
      min-height: 600px;
      border: 2px solid black;
    }
    .question {
      margin-bottom: 30px;
    }
    .question textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      resize: vertical;
    }
    .question input[type="text"] {
      width: 95%;
      padding: 8px;
      margin: 4px 0;
      font-size: 16px;
    }
    .question select {
      padding: 6px;
      font-size: 16px;
    }
    .actions {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 40px;
    }
    .btn {
      padding: 15px 50px;
      border: none;
      border-radius: 8px;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }
    .btn.cancel {
      background-color: black;
      color: white;
      width: 20%;
    }
    .btn.save {
      background-color: #ffdb4d;
      color: black;
      border: 2px solid black;
    }
    @media (max-width: 768px) {
      .quiz-content {
        padding: 20px;
      }
      .btn {
        width: 120px;
        padding: 10px;
      }
      .top-bar {
        flex-direction: column;
        height: auto;
        padding: 20px;
      }
      .top-bar .right {
        gap: 40px;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

<div class="top-bar">
  <div class="left">
    <img src="logo.png">
  </div>
  <div class="right">
    <img class="notif" src="notif.png" onclick="window.location.href='notif.php'">
    <div class="user-profile" onclick="window.location.href='profile.php'">
      <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" />
    </div>
  </div>
</div>

<div class="quiz-content">
  <div style="text-align: right; margin-bottom: 8px; margin-right: 10px;">
    <span class="edit" style="font-weight: bold; color: white;">Edit</span>
  </div>

  <form action="save_edit_quiz.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

    <div class="empty-box">
      <h2 style="text-align: center;">
        <?php echo ucfirst(htmlspecialchars($quiz['subject'])); ?>

        <input type="hidden" name="quizTitle" value="<?php echo htmlspecialchars($quiz['subject']); ?>">
      </h2>
      <?php $isFilipino = stripos($quiz['subject'], 'filipino') !== false; ?>

      <p style="font-size: 18px;">
        <strong>Description:</strong><br>
        <?php echo nl2br(htmlspecialchars($quiz['description'])); ?>
        <input type="hidden" name="quizDesc" value="<?php echo htmlspecialchars($quiz['description']); ?>">
      </p>
      <br>

      <?php foreach ($questionData as $i => $q): ?>
        <div class="question">
          <label for="q<?php echo $q['id']; ?>">
            <strong><?php echo ($i + 1) . "."; ?></strong>
          </label>
          <textarea id="q<?php echo $q['id']; ?>" name="questions[<?php echo $q['id']; ?>][text]" rows="1" style="width: 90%; display: inline-block;"><?php echo htmlspecialchars($q['question_text']); ?></textarea>

          <br><br>
          a. <input type="text" name="questions[<?php echo $q['id']; ?>][a]" value="<?php echo htmlspecialchars($q['option_a']); ?>"><br>
          b. <input type="text" name="questions[<?php echo $q['id']; ?>][b]" value="<?php echo htmlspecialchars($q['option_b']); ?>"><br>
          c. <input type="text" name="questions[<?php echo $q['id']; ?>][c]" value="<?php echo htmlspecialchars($q['option_c']); ?>"><br>
          d. <input type="text" name="questions[<?php echo $q['id']; ?>][d]" value="<?php echo htmlspecialchars($q['option_d']); ?>"><br>

          <label><strong><?php echo $isFilipino ? 'Wastong Sagot' : 'Correct Answer'; ?>:</strong>
  <select name="questions[<?php echo $q['id']; ?>][answer]">
    <?php foreach (['A', 'B', 'C', 'D'] as $letter): ?>
      <option value="<?php echo $letter; ?>" <?php if ($q['correct_answer'] === $letter) echo 'selected'; ?>>
        <?php echo $letter; ?>
      </option>
    <?php endforeach; ?>
  </select>
</label>
          <hr>
        </div>
      <?php endforeach; ?>

    </div>

    <div class="actions">
      <button class="btn cancel" type="button" onclick="window.location.href='dashboard.php';">Cancel</button>
      <button class="btn save" type="submit">Save changes</button>
    </div>
  </form>
</div>

</body>
</html>
