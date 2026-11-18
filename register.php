<?php
include 'db.php';

function sendNotificationEmail($toEmail, $subject, $messageBody) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourgmail@gmail.com'; // replace with your Gmail
        $mail->Password   = 'your-app-password';   // replace with your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Quizzify Notifications');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $messageBody;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    
    $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username or email already exists. Please try another.'); window.location.href='signin.php';</script>";
        exit();
    }

    $insert_sql = "INSERT INTO users (first_name, last_name, email, username, password)
                   VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. Please log in.'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='signin.php';</script>";
    }
}
if ($stmt->execute()) {
        // Send email notification
        $subject = "Welcome to Quizzify!";
        $message = "
            <p>Hello <strong>$first_name $last_name</strong>,</p>
            <p>Thank you for registering to <strong>Quizzify</strong>. Your account has been successfully created.</p>
            <p>Username: <strong>$username</strong></p>
            <p>We’re excited to have you on board!</p>
            <br>
            <p>– Quizzify Team</p>
        ";
        sendNotificationEmail($email, $subject, $message);

        echo "<script>alert('Registration successful. Please log in.'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='signin.php';</script>";
    }
?>

