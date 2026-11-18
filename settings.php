<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profilePic'];
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($file['type'], $allowedTypes)) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = 'profile_' . $user_id . '_' . time() . '.' . $ext;
        $uploadFile = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Update profile_pic path in DB
            $sql = "UPDATE users SET profile_pic = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $uploadFile, $user_id);
            $stmt->execute();
        } else {
            $uploadError = "Failed to upload file.";
        }
    } else {
        $uploadError = "Invalid file type. Only JPG, PNG, GIF allowed.";
    }
}

// Fetch user info
$sql = "SELECT username, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Use profile pic if set, else default image
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';
if (isset($_GET['email_updated']) && $_GET['email_updated'] == 1) {
    $message_email = "Email updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #3399ff;
      margin: 0;
      padding: 0;
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
    }

    h1 {
      text-align: center;
      color: white;
      margin-right: 50%;
      font-size: 30px;
    }

    .settings-container {
      max-width: 800px;
      margin: 150px auto;
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      border: 2px solid black;
    }

    .profile-header {
      text-align: center;
      margin-bottom: 40px;
      border-bottom: 1px solid black;
      padding-bottom: 30px;
      position: relative;
      width: fit-content;
      margin-left: auto;
      margin-right: auto;
    }

    .profile-pic-wrapper {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .profile-header img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      display: block;
    }

    .camera-icon-inside {
      position: absolute;
      bottom: 0;
      right: 0;
      background-color: white;
      border-radius: 50%;
      border: 2px solid #3399ff;
      padding: 4px;
      font-size: 16px;
      color: #3399ff;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      transition: background-color 0.3s;
    }

    .camera-icon-inside:hover {
      background-color: #e0f0ff;
    }

    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      gap: 10px;
    }

    .form-group label {
      width: 150px;
      font-weight: bold;
      font-size: 20px;
    }

    .form-group input {
      flex: 1;
      padding: 10px;
      font-size: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: white;
    }

    .form-group input:disabled {
      background-color: white;
      border: 1px solid #1e1e1e;
    }

    .form-group button {
      background: none;
      border: none;
      color: #3399ff;
      cursor: pointer;
      font-size: 20px;
      padding: 0 5px;
      text-decoration: underline;
    }

    .delete-btn {
      background-color: #333;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      float: right;
    }

    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }
  </style>
</head>
<body>

  <div class="top-bar">
  <div class="left-section">
    <img src="logo.png" alt="Logo" />
  </div>
  <div class="right-section">
    <img src="notif.png" class="notification-icon" onclick="window.location.href='notif.php'" />
    <div class="user-profile" onclick="document.getElementById('profilePicInput').click();">
      <img id="profilePicTop" src="<?php echo htmlspecialchars($profilePic); ?>" alt="User Profile" />
    </div>
  </div>
</div>

<h1>Settings</h1>

<div class="settings-container">
  <div class="profile-header">
    <div class="profile-pic-wrapper" onclick="document.getElementById('profilePicInput').click();">
      <img id="profilePicMain" src="<?php echo htmlspecialchars($profilePic); ?>" alt="User Profile" />
      <div class="camera-icon-inside">
        <i class="fa-solid fa-camera"></i>
      </div>
    </div>
    <h2><?php echo htmlspecialchars($user['username']); ?></h2>
    <p><?php echo htmlspecialchars($user['email']); ?></p>
  </div>

  <!-- Upload form -->
  <form method="POST" enctype="multipart/form-data" id="profilePicForm">
    <input type="file" name="profilePic" id="profilePicInput" accept="image/*" style="display:none" onchange="document.getElementById('profilePicForm').submit();" />
  </form>

  <div class="form-group">
    <label>Username:</label>
    <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled />
    <button onclick="window.location.href='editusername.php'">edit</button>
  </div>

  <div class="form-group">
    <label>Email address:</label>
    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled />
    <button onclick="window.location.href='edit-email.php'">edit</button>
  </div>

  <div class="form-group">
    <label>Password:</label>
    <input type="password" id="password" value="********" disabled />
    <button onclick="window.location.href='changepassword.php'">edit</button>
  </div>

  <div class="clearfix">
    <button class="delete-btn" onclick="window.location.href='deleteaccount.php'">Delete Account</button>
  </div>
</div>

<script>
  // Update preview immediately on file select
  const profilePicInput = document.getElementById('profilePicInput');
  const profilePicTop = document.getElementById('profilePicTop');
  const profilePicMain = document.getElementById('profilePicMain');

  profilePicInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
        profilePicTop.src = e.target.result;
        profilePicMain.src = e.target.result;
      }

      reader.readAsDataURL(file);
    }
  });
</script>
</body>
</html>
