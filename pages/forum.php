<?php
session_start();
require_once __DIR__ . '/../assets/database.php';
if (empty($_SESSION['memberID'])) {
  header('Location: ../pages/login.php');
  exit;
}
// Fetch questions
$stmt = sqlsrv_query($connect, "
  SELECT q.questionID, q.title,
         CONVERT(varchar(16), q.postedAt,120) AS postedAt,
         c.name AS category
  FROM questions q
  JOIN categories c ON q.categoryID=c.categoryID
  ORDER BY q.postedAt DESC
");
$questions = [];
while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $questions[] = $r;
}
// Fetch categories
$catsStmt   = sqlsrv_query($connect, "SELECT categoryID, name FROM categories ORDER BY name");
$categories = [];
while ($c = sqlsrv_fetch_array($catsStmt, SQLSRV_FETCH_ASSOC)) {
  $categories[] = [
    'id'   => (int)$c['categoryID'],
    'name' => $c['name']
  ];
}
$memberID = $_SESSION['memberID'];
$user = $_SESSION['memberName'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Librarya • Forum</title>
  <link rel="icon" href="https://i.imgur.com/d8X48fK.png" type="image/png">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
  <link href="../forum/style.css" rel="stylesheet">
</head>
<body>

  <!-- BACKGROUND -->

  <!-- HEADER -->
<header class="site-header">
  <div class="navbar d-flex align-items-center justify-content-between">
    <!-- left spacer, keep empty so brand stays centered -->
    <div class="nav-left"></div>

    <!-- your logo/brand in the middle -->
    <div class="brand text-center">
      <a href="../pages/home.php">
      <img src="https://i.imgur.com/d8X48fK.png" alt="Librarya Logo" class="nav-logo">
      </a>
    </div>

    <!-- user & search icons over on the right -->
    <div class="nav-right d-flex align-items-center">
      <div class="user-container">
        <i class="bi bi-person-fill user-icon"></i>
        <div class="user-dropdown">
          <?php if ($user): ?>
            <div class="dropdown-item"><?= htmlspecialchars($user) ?></div>
            <a href="../pages/logout.php" class="dropdown-item">Logout</a>
          <?php else: ?>
            <a href="../pages/login.php" class="dropdown-item">Login</a>
            <a href="../pages/register.php" class="dropdown-item">Register</a>
          <?php endif; ?>
          </div>
      </div>
    </div>
  </div>
  <hr class="nav-divider">
</header>

  <!-- SEARCH -->
  <div class="search-container text-center py-3">
    <button id="searchToggle" class="search-toggle"><i class="bi bi-search search-icon"></i></button>
    <div id="searchBox" class="search-box">
      <input id="searchInput" type="text" class="form-control rounded-pill mb-2" placeholder="Search threads…">
      <button id="searchGo" class="btn btn-outline-dark rounded-pill px-4">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>

  

  <!-- MAIN -->
  <main class="container-fluid forum-split py-4">
    <div class="row">
      <!-- CATEGORIES -->
      <div class="col-12 col-lg-4 forum-left px-4">
        <div id="categoryList" class="mb-4"></div>
        <div id="threadSection">
          <button id="backBtn" class="btn btn-link text-dark mb-3 d-none">
            <i class="bi bi-arrow-left"></i>
          </button>
        <div id="threadList" class="d-none">
          <div id="threadsContainer" class="thread-list"></div>
        </div>
      </div>
      </div>
      <!-- ASK -->
      <div class="col-12 col-lg-8 forum-right px-4">
        <div class="ask-card p-5 bg-white">
          <h4 class="mb-4"><i class="bi bi-chat-left-text me-2"></i>Ask a Question</h4>
          <form id="askForm" action="../forum/process.php" method="post">
            <input type="hidden" name="memberID" value="<?= $memberID ?>">
            <div class="mb-4">
              <input name="title" class="form-control form-control-lg rounded-pill px-4 py-3" placeholder="" required>
            </div>
            <div class="mb-4">
              <div id="askCategories" class="d-flex flex-wrap gap-5">
                <?php foreach($categories as $c): ?>
  <button
    type="button"
    class="btn ask-cat-btn"
    data-id="<?= $c['id'] ?>"
    data-cat="<?= htmlspecialchars($c['name']) ?>">
    <?= htmlspecialchars($c['name']) ?>
  </button>
<?php endforeach; ?>
              </div>
              <input type="hidden" name="categoryID" id="askCategoryInput" required>
            </div>
            <div class="mb-4">
              <textarea name="body" class="form-control rounded px-4 py-3" rows="6" placeholder="" required></textarea>
            </div>
            <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill py-3">
              Post
            </button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="text-center py-3 bg-white">
    © 2025 Librarya. All Rights Reserved
  </footer>

  <!-- DATA & SCRIPTS -->
  <script>
    
    const categories = <?= json_encode($categories) ?>;
    let questions    = <?= json_encode($questions) ?>;
  </script>
  <script src="../forum/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
