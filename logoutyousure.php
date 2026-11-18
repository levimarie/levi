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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout Confirmation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #3399ff;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
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
    .logout-container {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      border: 2px solid black;
      text-align: center;
      width: 400px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .logout-container h2 {
    
      margin-top: 50px;
    }

    .button-group {
      display: flex;
      justify-content: space-between;
      margin-top: 70px;
    }

    .button-group button {
      padding: 12px 20px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      border: none;
      flex: 1;
      margin: 0 10px;
      border:2px solid black;
    }

    .logout-btn {
      background-color: #f1c40f;
      
    }

    .cancel-btn {
      background-color: #2c2c2c;
      color: white;
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


  <div class="logout-container">
    <h2>Are you sure you want to log out?</h2>
    <div class="button-group">
      <button class="logout-btn" onclick="window.location.href='login.php'">Log Out</button>
      <button class="cancel-btn" onclick="window.location.href='profile.php'">Cancel</button>
    </div>
  </div>

  <script>
    function logout() {
      alert("Logging out...");
      window.location.href = "login.php"; 
    }

    function cancelLogout() {
      alert("Logout canceled.");
      history.back();
    }
  </script>

</body>
</html>
