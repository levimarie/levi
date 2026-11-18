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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Username</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #3399ff;
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
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
      margin-right: 4px;
    }

    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
    }

    .container {
      background-color: white;
      padding: 25px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      font-size: 20px;
      width: 600px;
      height:400px;
      margin-top: 200px;
      border: 2px solid black;
    }

    .form-group {
      margin-bottom: 30px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-left: 65px;
    }

    .form-group input {
      width: 80%;
      margin-left: 70px;
      margin-top: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .buttons {
      margin-top: 60px;
      display: flex;
      justify-content: center;
      gap: 40px;

    }

    .buttons button {
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      border:2px solid #1e1e1e;
    }

    .save-btn {
      background-color: #FFD700;
    
    }

    .cancel-btn {
      background-color: #333;
      color: white;
      width:150px;
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
    <h2>Change Password</h2>
    <div class="form-group">
     <form action="youwanttochangepassword.php" method="POST">
  <div class="form-group">
    <label for="current-password">Current Password</label>
    <input type="password" name="current_password" id="current-password" required>
  </div>
  <div class="form-group">
    <label for="new-password">New Password</label>
    <input type="password" name="new_password" id="new-password" required>
  </div>
  <div class="form-group">
    <label for="confirm-password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm-password" required>
  </div>
  <div class="buttons">
    <button type="submit" class="save-btn">Update Password</button>
    <button type="button" class="cancel-btn" onclick="window.location.href='settings.php'">Cancel</button>
  </div>
</form>

  <script>
    function saveChanges() {
      alert("Username successfully updated!");
    }
    function cancelChanges() {
      alert("Update canceled.");
    }
  </script>
</body>
</html>