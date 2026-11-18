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
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "root"; // change if not using default
$password = "";     // change if your MySQL has a password
$database = "quizify_db"; // replace with your DB name

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$fullName = $user['first_name'] . ' ' . $user['last_name'];
$email = $user['email'];

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
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
.user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      margin-bottom: 8px;;
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

    .profile-card {
      background-color: #fff;
      border-radius: 12px;
      width: 90%;
      max-width: 600px;
      margin: 200px auto;
      padding: 30px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
      border: 2px solid black;
    }

    .profile-card h2 {
      text-align: center;
      margin-bottom: 5px;
      font-size: 28px;
    }

    .profile-card p {
      text-align: center;
      margin-bottom: 20px;
      font-size: 16px;
      color: #555;
    }

    .profile-option {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 15px;
      background-color: #f1c40f;
      padding: 15px 20px;
      border-radius: 10px;
      margin: 10px 0;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      border: none;
    }

    .profile-option i {
      font-size: 22px;
      color: #333;
    }

    .profile-option span {
      font-size: 20px;
      font-weight: normal;
      color: #333;
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

<div class="profile-card">
  <h2><?php echo htmlspecialchars($fullName); ?></h2>
  <p><?php echo htmlspecialchars($email); ?></p>

  <button class="profile-option" onclick="window.location.href='settings.php'">
    <i class="fas fa-cog"></i>
    <span>Settings</span>
  </button>

  <button class="profile-option" onclick="window.location.href='privacypolicy.php'">
    <i class="fas fa-lock"></i>
    <span>Privacy Policy</span>
  </button>

  <button class="profile-option" onclick="window.location.href='logoutyousure.php'">
    <i class="fas fa-sign-out-alt"></i>
    <span>Log Out</span>
  </button>
</div>
</body>
</html>

