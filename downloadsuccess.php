<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Download Simulation</title>
  <meta http-equiv="refresh" content="60;url=dashboard.php">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3fa9f5;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      flex-direction: column;
    }

    .progress-container, .success-container {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .icon {
      width: 40px;
      height: 40px;
    }

    .text {
      font-size: 24px;
    }

    #successContainer {
      display: none;
    }
  </style>
</head>
<body>

  <div class="progress-container" id="progressContainer">
    <img id="fileIcon" src="" class="icon" alt="File Icon">
    <div class="text" id="progressText">Downloading . . . 0%</div>
  </div>

  <div class="success-container" id="successContainer">
    <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Check" class="icon">
    <div class="text">Download Successful!</div>
  </div>

  <script>
    const icons = {
      pdf: "https://img.icons8.com/color/48/000000/pdf.png",
      word: "https://img.icons8.com/color/48/000000/microsoft-word-2019--v2.png"
    };

    setTimeout(function() {
    window.location.href = 'dashboard.php';
  }, 10000);
   
    const params = new URLSearchParams(window.location.search);
    const fileType = params.get("file") || "pdf"; 

    document.getElementById("fileIcon").src = icons[fileType];

    let progress = 0;
    const progressText = document.getElementById("progressText");

    const interval = setInterval(() => {
      if (progress >= 100) {
        clearInterval(interval);
        document.getElementById("progressContainer").style.display = "none";
        document.getElementById("successContainer").style.display = "flex";
      } else {
        progress++;
        progressText.textContent = `Downloading . . . ${progress}%`;
      }
    }, 50);
  </script>

</body>
</html>