<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// ✅ Fetch profile picture
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'user-profile.jpg';

// ✅ Fetch all quizzes
$subjectFilter = isset($_GET['subject']) ? trim($_GET['subject']) : '';

if ($subjectFilter !== '') {
    // Filter by both user and subject
    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE user_id = ? AND subject LIKE ? ORDER BY created_at DESC");
    $likeFilter = '%' . $subjectFilter . '%';
    $stmt->bind_param("is", $user_id, $likeFilter);
    $stmt->execute();
    $quizResult = $stmt->get_result();
} else {
    // Show all quizzes by the current user
    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $quizResult = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #3399ff;
    }

    .top-bar {
      background-color: #2d2d2d;
      height: 80px;
      padding: 20px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
    }

    .left-section img {
      height: 130px;
      cursor: pointer;
    }

   .right-section {
      display: flex;
      align-items: center;
      gap: 30px;
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
      margin-top: 3px;
    }

    .container {
      padding: 20px;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      color: white;
    }

    .title-section {
      font-size: 40px;
      font-weight: bold;
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-left: 50px;
    }

    .dropdown {
      font-size: 20px;
      cursor: pointer;
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color:white;
      color: #1e1e1e;
      min-width: 100px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
      border-radius: 5px;
      z-index: 10;
      margin-top: 5px;
    }

    .dropdown-content div {
      padding: 8px 12px;
      cursor: pointer;
    }

    .dropdown-content div:hover {
      background-color: #eee;
    }

    .right-controls {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-top: -10px;
      position: relative;
    }

    .search-bar input {
      padding: 10px;
      border-radius: 20px;
      border: 2px solid black;
      width: 600px;
      font-size: 14px;
      outline: none;
      margin-left: 10%;
    }

    #search-results {
      background-color: #fff;
      color: black;
      min-width: 600px;
      border: 1px solid #ccc;
      border-radius: 5px;
      position: absolute;
      z-index: 20;
      top: 45px;
      left: 10%;
      max-height: 200px;
      overflow-y: auto;
    }

    #search-results div {
      padding: 10px 15px;
      cursor: pointer;
    }

    #search-results div:hover {
      background-color: #f0f0f0;
    }

    .see-all {
      font-size: 20px;
      text-decoration: underline;
      cursor: pointer;
      color:black;
      margin-top: 70px;
      margin-right: 8px;
    }

    .create-btn {
      display: block;
      margin: 50px auto 30px;
      background-color: #f1c40f;
      color: black;
      border: 2px solid black;
      padding: 14px 32px;
      font-size: 20px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      width: 360px;
    }

    .create-btn:hover {
      background-color: #e0b807;
    }

    .quiz-list {
      padding: 30px 50px;
    }

    .quiz-card {
      background-color: white;
      border: 1px solid black;
      border-radius: 10px;
      padding: 25px 35px;
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      max-width: 3000px;
      margin-left: auto;
      margin-right: auto;
      gap: 50px;
      cursor: pointer;
    }

    .quiz-info {
      flex-grow: 1;
    }

    .quiz-info h3 {
      font-size: 26px;
      margin: 0;
      color: #222;
    }

    .quiz-info p {
      font-size: 18px;
      margin: 10px 0 0;
      color: #555;
    }

    .actions {
      display: flex;
      gap: 15px;
      margin-top: 5px;
      flex-shrink: 0;
    }

    .actions a {
      text-decoration: none;
      font-size: 20px;
      padding: 10px 14px;
      background: #f1c40f;
      color: black;
      border: 2px solid black;
      border-radius: 8px;
      transition: background-color 0.2s;
    }

    .actions a:hover {
      background-color: #e0b807;
    }

    @media (max-width: 600px) {
      .header-bar {
        flex-direction: column;
        gap: 20px;
      }

      .search-bar input {
        width: 100%;
      }

      #search-results {
        min-width: 100%;
        left: 0;
      }
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

  <div class="container">
    <div class="header-bar">
      <div class="title-section">
        <div>My Quizzes</div>
        <div class="dropdown" onclick="toggleDropdown()">Subject ▼
          <div id="dropdown-content" class="dropdown-content">
            <div>English</div>
            <div>Filipino</div>
            <div>Science</div>
          </div>
        </div>
      </div>

      <div class="right-controls">
        <div class="search-bar">

         <form method="get" style="display: inline;">
         <input type="text" name="subject" placeholder="Search subject..." value="<?php echo htmlspecialchars($subjectFilter); ?>">
        </form>

          <div id="search-results" class="dropdown-content"></div>
        </div>
        <div class="see-all" onclick="window.location.href='seeall.php'">See All</div>
      </div>
    </div>
  </div>

  <!-- ✅ Quiz List -->
  <div class="quiz-list">
    <?php if ($quizResult->num_rows > 0): ?>
    <?php while ($quiz = $quizResult->fetch_assoc()): ?>
      
      <div class="quiz-card">
        <div class="quiz-info">
          <h3>
  <a href="seeallresult.php?quiz_id=<?php echo $quiz['id']; ?>" style="color: inherit; text-decoration: none;">
    <?php echo ucfirst(htmlspecialchars($quiz['subject'])); ?>
  </a>
</h3>

          <p><?php echo htmlspecialchars($quiz['description']); ?></p>
          
        </div>
        <div class="actions">
          <a href="createquiz.php?quiz_id=<?php echo $quiz['id']; ?>" title="Add">➕</a>
          <a href="editquiz.php?quiz_id=<?php echo $quiz['id']; ?>" title="Edit">✏️</a>
          <a href="yousurewantdeletequiz.php?quiz_id=<?php echo $quiz['id']; ?>" title="Delete">🗑️</a>
        </div>
      </div>
    <?php endwhile; ?>
    <?php else: ?>
    <div style="text-align: center; font-size: 22px; color: white; margin-top: 40px;">
      No recent quizzes found.
    </div>
  <?php endif; ?>
</div>
  </div>

  <!-- ✅ Create Button Always at Bottom -->
  <div style="text-align: center;">
    <button class="create-btn" onclick="window.location.href='createquiz.php'">Create Quiz</button>
  </div>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById("dropdown-content");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.closest('.dropdown')) {
        document.getElementById("dropdown-content").style.display = "none";
      }
    };

    const subjects = ["English", "Filipino", "Science"];
    const searchInput = document.querySelector(".search-bar input");
    const resultsContainer = document.getElementById("search-results");

    function showResults(matches) {
      resultsContainer.innerHTML = "";
      resultsContainer.style.display = "block";

      if (matches.length === 0) {
        const notFound = document.createElement("div");
        notFound.textContent = "Not Found";
        resultsContainer.appendChild(notFound);
      } else {
        matches.forEach(subject => {
          const item = document.createElement("div");
          item.textContent = subject;
          item.onclick = () => {
            window.location.href = subject.toLowerCase() + ".php";
          };
          resultsContainer.appendChild(item);
        });
      }
    }

    searchInput.addEventListener("input", function () {
      const query = this.value.toUpperCase().trim();
      if (query === "") {
        resultsContainer.style.display = "none";
        return;
      }

      const matches = subjects.filter(subject => subject.startsWith(query));
      showResults(matches);
    });

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".search-bar")) {
        resultsContainer.style.display = "none";
      }
    });

    function goToDetails(quizId) {
      window.location.href = 'quizdetails.php?quiz_id=' + quizId;
    }
  </script>
</body>
</html>
