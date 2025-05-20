<?php
// profile.php: Display member profile and borrowing history.

// Start session and check login
session_start();
if (empty($_SESSION['memberID'])) {
    header("Location: ../pages/login.php");
    exit();
}
$memberID = $_SESSION['memberID'];
$user = $_SESSION['memberName'] ?? null;

// Database connection (using sqlsrv and prepared statements for security)
$server = "libraryadb-server.database.windows.net,1433";
$connectionOptions = [
    "Database" => "libraryaDB",
    "Uid"      => "admin-librarya",
    "PWD"      => "hbuvoc%qAqB@32"
];
$conn = sqlsrv_connect($server, $connectionOptions);
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Fetch member personal details
$sqlMember = "SELECT name, nic, email, phoneNo, dateRegistered 
              FROM members WHERE memberID = ?";
$params    = [ $memberID ];
$stmt      = sqlsrv_query($conn, $sqlMember, $params);
if (!$stmt) {
    die("SQL error: " . print_r(sqlsrv_errors(), true));
}
$member = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$member) {
    echo "<div style='padding:20px;background:#ffecec;color:#900;border:2px solid #f00;'>
            ❌ No member found for ID: <strong>$memberID</strong>
          </div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Librarya • Profile</title>
  <link rel="icon" href="https://i.imgur.com/d8X48fK.png" type="image/png">
  <!-- Slick Carousel CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- Custom Styles -->
  <link rel="stylesheet" href="../profile/style.css" />
</head>
<body>
  <!-- Navigation Bar -->
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


  <section class="section-spacer"></section>

  <!-- Profile Info -->
  <section class="text-center">
  <div class="container">
    <h1><b><?= htmlspecialchars($member['name']); ?></b></h1>
    <p class="tagline"><b>NIC: </b><?= htmlspecialchars($member['nic']); ?></p>
    <p class="tagline"><b>Email: </b><?= htmlspecialchars($member['email']); ?></p>
    <p class="tagline"><b>Phone: </b><?= htmlspecialchars($member['phoneNo']); ?></p>
    <p class="tagline"><b>Since: </b><?= $member['dateRegistered']->format('Y-m-d'); ?></p>
  </div>
</section>

  <section class="section-spacer"></section>

  <!-- Book History Carousel -->
  <section id="history" class="latest-news-section">
    <div class="container text-center">
      <h2>Book History</h2>
      <div class="custom-carousel-wrapper position-relative">
        <button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>
        <button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>
        <div class="book-carousel">
          <?php
          $sqlHistory   = "SELECT b.cover, b.title, b.author, r.returnDate 
                           FROM returns r
                           JOIN books b ON r.isbn = b.isbn
                           WHERE r.memberID = ?
                           ORDER BY r.returnDate DESC";
          $stmtHistory  = sqlsrv_query($conn, $sqlHistory, $params);
          if ($stmtHistory) {
            while ($row = sqlsrv_fetch_array($stmtHistory, SQLSRV_FETCH_ASSOC)) {
              $cover   = htmlspecialchars($row['cover']);
              $title   = htmlspecialchars($row['title']);
              $author  = htmlspecialchars($row['author']);
              $retDate = $row['returnDate'] 
                         ? $row['returnDate']->format('Y-m-d') 
                         : 'N/A';
              echo "<div class=\"book-slide-wrapper\">";
              echo "  <img src=\"{$cover}\" alt=\"{$title}\">";
              echo "  <h4 class=\"book-title\">{$title}<br>
                     <small>{$author}<br>Returned: {$retDate}</small></h4>";
              echo "</div>";
            }
          }
          sqlsrv_free_stmt($stmtHistory);
          sqlsrv_close($conn);
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="footer">
    <p class="text-center text-muted mt-2 mb-0">&copy; 2025 Librarya. All Rights Reserved.</p>
  </footer>

  <!-- Overlay Menu -->
  <nav id="menu-overlay" class="menu-overlay">
    <div class="menu-inner">
      <a href="#" id="close-btn" class="close-btn">X</a>
      <ul class="menu-links">
        <li><a href="../pages/books.php">Books</a></li>
        <li><a href="../pages/profile.php">Profile</a></li>
        <li><a href="../pages/forum.php">Threads & Posts</a></li>
        <li><a href="#">Weekly Reader's Picks</a></li>
        <li><a href="../pages/login.php">Login</a></li>
        <li><a href="../pages/register.php">Register</a></li>
      </ul>
    </div>
  </nav>

  <script src="../profile/script.js"></script>
  <script src="../profile/script.js"></script>
  <!-- Bootstrap Bundle (Popper + JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script>
    $('.book-carousel').slick({
      slidesToShow: 3,
      centerMode: true,
      centerPadding: '0px',
      autoplay: true,
      autoplaySpeed: 3000,
      infinite: true,
      arrows: false,
      dots: true
    });
    $('.slick-prev').on('click', ()=>$('.book-carousel').slick('slickPrev'));
    $('.slick-next').on('click', ()=>$('.book-carousel').slick('slickNext'));
  </script>
</body>
</html>

