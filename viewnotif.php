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

// Fetch new notifications
$new_sql = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
$new_stmt = $conn->prepare($new_sql);
$new_stmt->bind_param("i", $user_id);
$new_stmt->execute();
$new_result = $new_stmt->get_result();

// Fetch previous notifications
$old_sql = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 1 ORDER BY created_at DESC";
$old_stmt = $conn->prepare($old_sql);
$old_stmt->bind_param("i", $user_id);
$old_stmt->execute();
$old_result = $old_stmt->get_result();

// Mark new notifications as read
$update_sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $user_id);
$update_stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Notifications</title>
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
      font-size: 30px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .notification-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }
    .notification-time {
      font-size: 12px;
      color: #777;
    }
    .notif-section-title {
      font-weight: bold;
      font-size: 24px;
      margin-top: 30px;
      color: #2c3e50;
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
    .scrollable-container {
      margin-top: 15px;
      max-height: 200px; 
      overflow-y: auto; 
      padding-right: 10px;
      border-top: 1px solid #ccc;
    }
    .alert {
      padding: 10px;
      margin: 10px 0;
      border-radius: 4px;
    }
    .alert-success {
      background-color: #dff0d8;
      color: #3c763d;
      border: 1px solid #d6e9c6;
    }
    .alert-error {
      background-color: #f2dede;
      color: #a94442;
      border: 1px solid #ebccd1;
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
    <h2><i class="fas fa-bell"></i> All Notifications</h2>
    
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

    <div class="scrollable-container">
      <div class="notif-section-title">New Notifications</div>
      <?php if ($new_result->num_rows > 0): ?>
        <?php while ($row = $new_result->fetch_assoc()): ?>
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
        <p>No new notifications.</p>
      <?php endif; ?>

      <div class="notif-section-title">Previous Notifications</div>
      <?php if ($old_result->num_rows > 0): ?>
        <?php while ($row = $old_result->fetch_assoc()): ?>
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
        <p>No previous notifications.</p>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>