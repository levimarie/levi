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
  <title>Notifications</title>
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
       margin-right: 50px;
    }

    .notification-icon {
      width: 70px;
      height: 70px;
      cursor: pointer;
      border-radius: 50%;
      margin-right: 50px;
      
    }


    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      margin-top: 1px;
    }


    .notifications-box {
      background-color: #ffffff;
      width: 90%;
      height:300px;
      max-width: 500px;
      margin: 200px auto;
      border: 2px solid black;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
      
    }

    .notifications-box h2 {
      margin: 0;
      font-size: 30px;
      display: flex;
      align-items: center;
      gap: 10px;
      
    }

    .button-group {
      margin-top: 15px;
      display: flex;
    }

    .button-group button {
      padding: 12px 60px;
      font-weight: bold;
      border: 2px solid black;
      cursor: pointer;
      font-size: 12px;
    }

    .view-btn {
      background-color: #f1c40f;
      border-top-left-radius: 5px;
      border-bottom-left-radius: 5px;
    }

    .clear-btn {
      background-color: #2c2c2c;
      color: white;
      border-top-right-radius: 5px;
      border-bottom-right-radius: 5px;
    }

    .scrollable-container {
      margin-top: 15px;
      max-height: 200px; 
      overflow-y: auto; 
      padding-right: 10px;
      border-top: 1px solid #ccc;
    }

    .scrollable-container h2 {
      font-size: 18px;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <div class="left-section">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="right-section">
      <img src="notif.png" class="notification-icon" onclick="window.location.href='notif.html'">
      <div class="user-profile" onclick="window.location.href='profile.html'">
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" />
      </div>
    </div>
  </div>

  <div class="notifications-box">
    <h2><i class="fas fa-bell"></i> Notifications</h2>
    <div class="button-group">
      <button class="view-btn" onclick="window.location.href='viewnotif.html'">View All Notifications</button>
      <button class="clear-btn" onclick="window.location.href='clearnotif.html'">Clear All Notifications</button>
    </div>
    <div class="scrollable-container">
      <h2>New</h2>
      <p>Sample notification content here...</p>
      <p>Another new notification...</p>
      <p>More new notifications...</p>
      <p>New alerts and updates...</p>
      <br>
      <h2>Previous</h2>
      <p>Older notifications appear here...</p>
      <p>Old notification details...</p>
      <p>More previous alerts...</p>
      <p>Past messages...</p>
    </div>
  </div>

</body>
</html>
