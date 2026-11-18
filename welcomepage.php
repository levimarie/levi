<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
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
    max-width: 800px;
}

.welcome-text {
    font-family: 'Roboto', sans-serif;
    font-size: 64px;
    color: white;
    font-weight: bold;
    margin-bottom: 20px;
}

.subtext {
    font-family: Arial, sans-serif;
    font-size: 24px; 
    color: white;
    margin-bottom: 40px;
}

.start-btn {
    background-color: black;
    color: white;
    font-size: 28px;
    font-weight: bold;
    padding: 20px 60px; 
    border: none;
    border-radius: 10px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="welcome-text">Welcome Teachers</h1>
        <p class="subtext">Empowering Teachers to create engaging quizzes effortlessly</p>
        <button class="start-btn" onclick="window.location.href='dashboard.php'">Start</button>
    </div>
</body>
</html>