<?php 
session_start();
include 'db.php';
function add_notification($conn, $user_id, $message, $type = 'general') {
    $created_at = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, created_at, status, is_read) VALUES (?, ?, ?, 'unread', 0)");
    $stmt->bind_param("iss", $user_id, $message, $created_at);
    $stmt->execute();
}
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            if (!empty($_POST['remember'])) {
        setcookie("remember_username", $username, time() + (86400 * 30), "/");
    } else {

        setcookie("remember_username", "", time() - 3600, "/");
    }
    add_notification($conn, $user["id"], "You have successfully logged in to Quizify", "login");
            header("Location: welcomepage.php");
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "User not found.";
    }


}
?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login Page</title> 
    <style> 
        body { 
            font-family: Arial, sans-serif; 
            background-color: #3399ff;  
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            flex-direction: column; 
        } 
        .login-container { 
            text-align: center; 
            width: 100%; 
            max-width: 400px; 
        } 
        .logo img { 
            width: 80px; 
            height: auto; 
            border-radius: 50%; 
            background: white; 
            padding: 10px; 
        } 
        .subtitle { 
            font-size: 14px; 
            color: white; 
            margin-top: 10px; 
        } 
        input[type="text"], 
        input[type="password"] { 
            width: 100%; 
            padding: 10px; 
            margin-top: 10px; 
            border: 2px solid black; 
            border-radius: 5px; 
            font-size: 14px; 
        } 
        .options { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            font-size: 12px; 
            margin: 10px 0; 
            color: white; 
        } 
        .options label { 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            color: white; 
        } 
        .options a { 
            text-decoration: none; 
            color: white; 
        } 
        button { 
            width: 105%; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            font-size: 16px; 
            cursor: pointer; 
            margin-top: 10px; 
        } 
        .login-btn { 
            background-color: black; 
            color: white; 
        } 
        .signin-btn { 
            background-color: yellow; 
            color: black; 
            border: 2px solid black; 
        } 
    </style> 
</head> 
<body> 
    <div class="login-container"> 
        <div class="logo"> 
            <img src="logo.png" alt="Logo"> 
        </div> 
        <p class="subtitle">Please fill out your login details below</p> 
        <!-- ✅ FORM now correctly posts to login.php -->
        <form method="POST" action="login.php">
            <input type="text" id="username" name="username" placeholder="Username" required> 
            <input type="password" id="password" name="password" placeholder="Password" required> 

            <?php if (!empty($error)) : ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="options"> 
                <label>
                    <input type="checkbox" id="remember"> Remember Me
                </label> 
                <a href="#" class="forgot-password" onclick="window.location.href='forgotpassword.php'">Forgot Password?</a> 
            </div> 

            <!-- ✅ Removed onsubmit from button -->
            <button type="submit" class="login-btn">Log in</button> 
            <button type="button" class="signin-btn" onclick="window.location.href='signin.php'">Sign in</button> 
        </form> 
    </div> 

    <script>
    function validateLogin() {
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        if (!username || !password) {
            alert("Please enter both username and password.");
            return false;
        }

        return true;
    }
    </script>
</body> 
</html>
