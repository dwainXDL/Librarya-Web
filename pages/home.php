<?php
// home.php
// Start session before any output
session_start();

// Get logged-in username or null
$userName = $_SESSION['memberName'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Librarya • Home</title>
  <link rel="icon" href="https://i.imgur.com/d8X48fK.png" type="image/png">

  <!-- Slick Carousel CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="../home/style.css" />
</head>
<body>

  <!-- Top Navigation Bar -->
  <header>
    <div class="navbar">
      <!-- Hamburger Toggle -->
      <div class="menu-toggle" id="menu-toggle">
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <span class="menu-label"></span>
        <span class="close-label"></span>
      </div>
      <div class="nav-separator"></div>

      <!-- Brand Logo -->
      <div class="brand">
        <img src="https://i.imgur.com/d8X48fK.png" alt="Librarya Logo" class="nav-logo" />
      </div>

      <!-- Right Side Links -->
      <div class="nav-right d-flex align-items-center">
        <div class="user-container">
  <i class="fas fa-user user-icon"></i>

  <div class="user-dropdown">
    <?php if ($userName): ?>
      <div class="dropdown-item"><?= htmlspecialchars($userName) ?></div>
      <a href="../pages/logout.php" class="dropdown-item">Logout</a>
    <?php else: ?>
      <a href="../pages/login.php" class="dropdown-item">Login</a>
      <a href="../pages/register.php" class="dropdown-item">Register</a>
    <?php endif; ?>
  </div>
</div>

        <a href="#footer" class="phone-link" title="Contact">
          <i class="fas fa-phone"></i>
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <video class="background-video" autoplay muted loop playsinline>
      <source src="https://storelibrarya.blob.core.windows.net/website-video/home.mp4" type="video/mp4" />
    </video>
    <div class="hero-overlay">
      <h1>Welcome to Librarya</h1>
      <p>Browse our latest arrivals, reserve your next read and join discussions all in one place</p>
      <a href="#" class="btn">Discover Now</a>
    </div>
  </section>

  <!-- Spacer Sections -->
  <section class="spacer-section"></section>
  <section class="section-spacer"></section>

  <!-- Quote Section -->
  <section class="quote-section text-center">
    <div class="container">
      <p class="library-quote">
        Enter, and explore every chapter. Immerse,<br>
        and discover a curated world of literary brilliance.
      </p>
      <a href="../pages/books.php" class="quote-button">Browse Collection</a>
    </div>
  </section>

  <section class="section-spacer"></section>

  <!-- New Arrivals Carousel -->
  <section id="news" class="latest-news-section">
    <div class="container text-center">
      <h2 class="mb-4">New Arrivals</h2>
      <div class="custom-carousel-wrapper position-relative">
        <button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>
        <button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>
        <div class="book-carousel">
          <?php include '../home/new-arrivals.php'; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="footer">
    <div class="container py-4">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
        <div class="footer-contact mb-3 mb-md-0">
          <p class="mb-1"><i class="fas fa-phone-alt me-2"></i> +94 77 123 4567</p>
          <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> NSBM Green University, Homagama</p>
          <p class="mb-0"><i class="fas fa-envelope me-2"></i> librarya@mail.com</p>
        </div>
        <div class="footer-action">
          <a href="../pages/forum.php" class="btn btn-outline-dark">
            <i class="fas fa-comment-dots"></i> Forum
          </a>
        </div>
      </div>
      <p class="text-center text-muted mt-5 mb-0">&copy; 2025 Librarya. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Overlay Menu -->
  <nav id="menu-overlay" class="menu-overlay">
    <div class="menu-inner">
      <a href="#" id="close-btn" class="close-btn">X</a>
      <ul class="menu-links">
        <li><a href="../pages/books.php">Books</a></li>
        <li><a href="../pages/profile.php">Profile</a></li>
        <li><a href="../pages/forum.php">Forum</a></li>
        <li><a href="../pages/login.php">Login</a></li>
        <li><a href="../pages/register.php">Register</a></li>
      </ul>
    </div>
  </nav>

  <!-- JavaScript -->
  <script src="../home/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>
</html>
