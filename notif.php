<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get user profile picture
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

// Handle clear all notifications
if (isset($_POST['clear_notifications'])) {
    $delete_sql = "DELETE FROM notifications WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);
    
    if ($delete_stmt->execute()) {
        $success_message = "All notifications cleared successfully!";
    } else {
        $error_message = "Error clearing notifications";
    }
}

// Fetch notifications
$notif_sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$notif_stmt = $conn->prepare($notif_sql);
$notif_stmt->bind_param("i", $user_id);
$notif_stmt->execute();
$notif_result = $notif_stmt->get_result();
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
      margin-right: 4px;
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
      max-width: 600px;
      margin: 200px auto;
      border: 2px solid black;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
    }
    .notifications-box h2 {
      margin: 0;
      font-size: 35px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .button-group {
      margin-top: 15px;
      display: flex;
    }
    .button-group button {
      padding: 12px 62px;
      font-weight: bold;
      border: 2px solid black;
      cursor: pointer;
      font-size: 16px;
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
    .notification-message {
      margin-top: 20px;
      font-size: 20px;
      color: #333;
      line-height: 1.6;
      max-height: 300px;
      overflow-y: auto;
    }
    .notification-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }
    .notification-time {
      font-size: 12px;
      color: #777;
    }
    .alert {
      padding: 10px;
      margin: 10px 0;
      border-radius: 4px;
    }
    .alert-success {
      background-color: #dff0d8;
      color: #3c763d;
    }
    .alert-error {
      background-color: #f2dede;
      color: #a94442;
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

<div class="notifications-box">
  <h2><i class="fas fa-bell"></i> Notifications</h2>
  
  <?php if (isset($success_message)): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
  <?php endif; ?>
  
  <?php if (isset($error_message)): ?>
    <div class="alert alert-error"><?php echo $error_message; ?></div>
  <?php endif; ?>

  <form method="POST" onsubmit="return confirm('Are you sure you want to clear all notifications?');">
    <div class="button-group">
      <button type="button" class="view-btn" onclick="window.location.href='viewnotif.php'">View All Notifications</button>
      <button type="submit" name="clear_notifications" class="clear-btn">Clear All Notifications</button>
    </div>
  </form>

  <div class="notification-message">
    <?php if ($notif_result->num_rows > 0): ?>
      <?php while ($row = $notif_result->fetch_assoc()): ?>
        <div class="notification-item">
          <?php
            $message = $row['message'];
            if (stripos($message, 'quiz') !== false && stripos($message, 'created') !== false) {
                echo "Your quiz has been successfully created.";
            } else {
                echo htmlspecialchars($message);
            }
          ?>
          <div class="notification-time">
            <?php echo date("F j, Y g:i A", strtotime($row['created_at'])); ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No notifications yet.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>