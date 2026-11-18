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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Privacy Policy</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      margin-right: 4px;
      
    }


    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      margin-bottom: 0px;
    }


    .privacy-card {
      background-color: white;
      max-width: 600px;
      margin: 200px auto;
      height:300px;
      padding: 25px;
      border-radius: 10px;
      border: 2px solid black;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }

    .privacy-card h2 {
      margin-top: 0;
    }

    .privacy-card p {
      line-height: 1.6;
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
  
  <div class="privacy-card">
    <h2>Privacy Policy</h2><br>
    <p>We value your privacy and are committed to protecting your personal information.<br>
    We collect your name, email, and activity data to enhance your experience.<br>
    Your data is used for managing your account, improving features, and sending updates.<br>
    Rest assured that your information is safeguarded against unauthorized access.<br>
    We do not share your data unless required by law.<br>
    You have the right to access, update, or request deletion of your data at any time.<br>
    If you have any questions, please contact us at quizify@gmail.com.</p>
  </div>

</body>
</html>

