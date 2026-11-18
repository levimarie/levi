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


// Check if quiz_id is passed
if (!isset($_GET['quiz_id'])) {
    header("Location: dashboard.php");
    exit();
}

$quiz_id = $_GET['quiz_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_delete"])) {
    $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account Confirmation</title>
    <style>
        body {
            background-color: #3399ff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
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
      
    }

    .user-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      margin-top: 9px;
    }
        .dialog-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            height:300px;
            border:2px solid black;
        }
        .dialog-box .warning-icon {
            font-size: 20px;
            color: red;
            width:20px;
            height:150px;
        }
        .dialog-box img{
           color: red;
           width:95px;
           margin-left: 200px;
           margin-top: 23px;
        }
        .dialog-box p {
            margin: 2px 0;
            font-size: 26px;
        }
        .dialog-box button {
            padding: 10px 30px;
            margin: 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 3px;
        }
        .dialog-box .yes-button {
            background-color: #FFD700;
            border:2px solid black;
            
        }
        .dialog-box .no-button {
            background-color: #333;
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
      <img src="notif.png" class="notification-icon" onclick="window.location.href='notif.html'">
      <div class="user-profile" onclick="window.location.href='profile.html'">
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" />
      </div>
    </div>
  </div>

    <div class="dialog-box">
        <div class="warning-icon">
          <img src="warning.png">
        </div>
        <p class="message">Are you sure want to <br>delete your quiz?</p>
        <form method="POST">
        <button type="submit" name="confirm_delete" class="yes-button">Yes</button>
        <button type="button" class="no-button" onclick="window.location.href='dashboard.php'">No</button>
    </form>
    </div>

    <script>
        function deleteAccount() {
            alert("Your quiz has been deleted.");
        }
        function cancelDelete() {
            alert("Account quiz canceled.");
        }
    </script>
</body>
</html>
