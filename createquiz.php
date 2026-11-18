<?php 
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"] )) {
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Quiz</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3399ff;
    }

    .top-bar {
      background-color: #2c2c2c;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      height: 80px;
      color: white;
    }

    .left-section img {
      height: 130px;
      cursor: pointer;
    }

   .right-section {
      display: flex;
      align-items: center;
      gap: 30px;
      margin-right: 10px;
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
      margin-top: 3px;
    }



    .container {
      width: 100%;
      padding: 40px;
      box-sizing: border-box;
      padding-top: 30px;
    }

    h2 {
      color: white;
      font-size: 36px;
      margin-bottom: 30px;
    }

    .combined-box, .single-box {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .form-row {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .form-row label {
      font-weight: bold;
      font-size: 18px;
      min-width: 180px;
      margin-right: 15px;
    }

    input[type="text"], textarea, select {
      padding: 10px;
      font-size: 18px;
      border-radius: 5px;
      border: 2px solid black;
    }

    input[type="text"], textarea {
      width: 100%;
    }

    textarea {
      resize: none;
      height: 80px;
    }

    .radio-group {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-left: 10px;
    }

    .buttons {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 30px;
    }

    .cancel-btn, .next-btn {
      font-size: 20px;
      font-weight: bold;
      padding: 15px 50px;
      border: 2px solid #1e1e1e;
      border-radius: 8px;
      cursor: pointer;
    }

    .cancel-btn {
      background-color: black;
      color: white;
    }

    .next-btn {
      background-color: #ffdb4d;
      color: black;
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        align-items: flex-start;
      }

      .form-row label {
        margin-bottom: 10px;
      }

      input[type="text"], textarea {
        width: 100%;
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

  <div class="container">
    <h2>Create Quiz</h2>

    <!-- ✅ Wrap all inputs in a form -->
    <form method="POST" action="createquiz2.php">
      <div class="combined-box">
        <div class="form-row">
          <label for="quizTitle">Quiz Title:</label>
          <input type="text" id="quizTitle" name="quizTitle" required />
        </div>
        <div class="form-row">
          <label for="quizDesc">Description:</label>
          <textarea id="quizDesc" name="quizDesc" required></textarea>
        </div>
      </div>

      <div class="single-box">
        <label for="numQuestions">Number of Questions:</label>
        <select id="numQuestions" name="numQuestions">
          <option>10</option>
          <option>20</option>
          <option>30</option>
          <option>40</option>
          <option>50</option>

        </select>
      </div>

      <div class="single-box">
        <label>Question Type:</label>
        <div class="radio-group">
          <input type="radio" id="mc" name="qtype" value="mc" checked />
          <label for="mc">Multiple Choice</label>
        </div>
      </div>

      <div class="single-box">
        <label for="pointsPerItem">Points Per Item:</label>
        <select id="pointsPerItem" name="pointsPerItem">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>

      <div class="buttons">
        <button class="cancel-btn" type="button" onclick="window.location.href='dashboard.php'">Cancel</button>
        <button class="next-btn" type="submit">Next</button>
      </div>
    </form>
  </div>
</body>
</html>
