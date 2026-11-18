<?php 
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION["user_id"];
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Quizzes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3399ff
    }

    .top-bar {
      background-color: #2c2c2c;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      height: 80px;
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      color: white;
    }

    .left-section img {
      height: 130px;
    }

    .right-section {
      display: flex;
      align-items: center;
      gap: 30px;
      font-size: 40px;
      cursor: pointer;
      margin-right: 50px;
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
      cursor: pointer;
      margin-bottom: 8px;
      margin-top:16px;
    }

    .container {
      padding: 200px;
      width: 100%;
      border-radius: 0 0 10px 10px;
      box-sizing: border-box;
    }

    h2 {
      color: white;
      font-size: 32px;
      margin-left: 1px;
    }

    .table-header {
      display: flex;
      background: #ffd700;
      font-weight: bold;
      border-radius: 10px;
      overflow: hidden;
      margin: 0 auto;
      max-width: 500%;
      padding:15px;
    }

    .quiz-row {
      display: flex;
      background: white;
      padding:15px;
      margin: 20px auto 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
      max-width: 100%;
    }

    .cell {
      flex: 1;
      padding: 15px;
      text-align: center;
      font-size: 16px;
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
  
  <div class="container">
    <h2>My Quizzes</h2>

    <div class="table-header">
      <div class="cell">Subject</div>
      <div class="cell">No. of Questions</div>
      <div class="cell">Total Score</div>
    </div>

    <div id="quizTable"></div>
  </div>

  <script>
    fetch('api_myquizzes.php')
      .then(res => res.json())
      .then(data => {
        const quizTable = document.getElementById('quizTable');
        data.quizzes.forEach(quiz => {
          const div = document.createElement('div');
          div.className = 'quiz-row';
          div.innerHTML = `
            <div class="cell">${quiz.subject.charAt(0).toUpperCase() + quiz.subject.slice(1)}</div>
            <div class="cell">${quiz.num_questions}</div>
            <div class="cell">${quiz.total_score}</div>
          `;
          quizTable.appendChild(div);
        });
      })
      .catch(err => {
        console.error("Error loading quizzes:", err);
      });
  </script>

</body>
</html>
