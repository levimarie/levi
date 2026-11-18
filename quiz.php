<?php
include "db.php";

$subject = "Filipino"; // change to "English" or "Science" as needed
$num = 10; // number of random questions

$stmt = $conn->prepare("SELECT * FROM questions WHERE subject = ? ORDER BY RAND() LIMIT ?");
$stmt->bind_param("si", $subject, $num);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= $subject ?> Quiz</title>
  <style>
    body {
      font-family: Arial;
      background-color: #3399ff;
      padding: 20px;
    }
    .box {
      background-color: white;
      border: 2px solid black;
      padding: 20px;
      max-width: 800px;
      margin: auto;
      border-radius: 10px;
    }
    .question {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<div class="box">
  <h2><?= $subject ?> Quiz</h2>
  <form action="submit_quiz.php" method="post">
    <?php
    $num = 1;
    while ($q = $result->fetch_assoc()) {
      echo "<div class='question'>";
      echo "<p><strong>Q{$num}:</strong> {$q['question']}</p>";
      foreach (['A', 'B', 'C', 'D'] as $letter) {
        echo "<label><input type='radio' name='q{$q['id']}' value='{$letter}'> " . $q["option_" . strtolower($letter)] . "</label><br>";
      }
      echo "</div>";
      $num++;
    }
    ?>
    <input type="submit" value="Submit Quiz">
  </form>
</div>
</body>
</html>