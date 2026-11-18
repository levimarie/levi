<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get the current email from database
$sql = "SELECT profile_pic, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

// Retrieve values from POST
$current_email = $_POST['current_email'] ?? '';
$new_email = $_POST['new_email'] ?? '';
$confirm_email = $_POST['confirm_email'] ?? '';

// Basic validation
if ($new_email !== $confirm_email) {
    echo "<script>alert('New email and confirmation do not match.'); window.history.back();</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirm Email Change</title>
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
        .dialog-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            height: 300px;
            border: 2px solid black;
            margin-top: 120px;
        }
        .dialog-box .warning-icon {
            font-size: 20px;
            color: red;
            width: 20px;
            height: 150px;
        }
        .dialog-box img {
            width: 95px;
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
            border: 2px solid black;
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
            <img src="logo.png" alt="Logo" />
        </div>
        <div class="right-section">
            <img src="notif.png" class="notification-icon" onclick="window.location.href='notif.php'" />
            <div class="user-profile" onclick="window.location.href='profile.php'">
                <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" />
            </div>
        </div>
    </div>

    <div class="dialog-box">
        <div class="warning-icon">
            <img src="warning.png" alt="Warning" />
        </div>
        <p class="message">Are you sure you want to <br>change your email address?</p>
        
        <form action="update_email.php" method="POST" style="display:inline;">
            <!-- Hidden values for email update -->
            <input type="hidden" name="current_email" value="<?php echo htmlspecialchars($current_email); ?>">
            <input type="hidden" name="new_email" value="<?php echo htmlspecialchars($new_email); ?>">
            <input type="hidden" name="confirm_email" value="<?php echo htmlspecialchars($confirm_email); ?>">
            <button type="submit" class="yes-button">Yes</button>
        </form>

        <button class="no-button" onclick="window.location.href='edit-email.php'">No</button>
    </div>
</body>
</html>
