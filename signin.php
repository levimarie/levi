<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
<style>
    /* Import Roboto font */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap');

body {
    background-color: #3399ff; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
    width: 350px; 
}

.title {
    font-family: 'Roboto', sans-serif;
    font-size: 28px;
    color: black;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    
}

input, button {
    width: 100%; 
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    border: 2px solid black;
}

.register-btn {
    background-color: yellow;
    color: black;
    font-weight: bold;
    border: none;
    cursor: pointer;
    width: 107%;
}

.login-btn {
    background-color: black;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    width: 107%;
}
</style>
</head>
<body>
    <div class="container">
        <h2 class="title">Sign up</h2>
       <form action="register.php" method="POST">
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="username" name="username" placeholder="Username" required>
            <input type="password" name="password"  placeholder="Password" required>
            <button class="register-btn">Register</button>
            <button class="login-btn" type="button" onclick="window.location.href='login.php'">Log in</button>
</form>
    </div>
</body>
</html>
