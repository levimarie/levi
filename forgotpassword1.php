<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

*{

    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #3399ff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 400px;
}

.card {
    background: white;
    padding: 20px 25px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    width: 450px;
    text-align: left;
    border: 2px solid black;
    display: flex;
    flex-direction: column;
}

h2 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 0px;

}
.p1{
    font-size: 13px;
    margin-bottom: 40px;
}

p {
    font-size: 15px;
    color: #333;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 2px solid #3399ff;
    border-radius: 6px;
    outline: none;
    margin-bottom: 15px;
}

.buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
}

button {
    padding: 5px;
    margin-bottom: 30px;
    font-size: 14px;
    font-weight: 600;
    border: 2px solid black;
    cursor: pointer;
    border-radius: 6px;
    width: 100px;
    text-align: center;
}

.next {
    background: black;
    color: white;
}

.cancel {
    background: #ffcc00;
    color: black;
}
</style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2><b>Set New Password</b></h2>
            <form action="reset_password.php" method="POST">
                <p class="p1">Please create a new password must be at least 8-12 characters.</p>
                <p><b>New Password</b></p>
                <input type="password" name="new_password" required minlength="8" maxlength="12">
                <p><b>Verify Password</b></p>
                <input type="password" name="confirm_password" required minlength="8" maxlength="12">
                <div class="buttons">
                    <button class="next" type="submit">Next</button>
                    <button class="cancel" type="button" onclick="window.location.href='login.php'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>