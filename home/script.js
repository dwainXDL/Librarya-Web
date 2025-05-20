document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle');
  const menuOverlay = document.getElementById('menu-overlay');
  const closeBtn = document.getElementById('close-btn');
  const menuLinks = document.querySelectorAll('.menu-links li');
  const userIcon = document.querySelector('.user-container');
  const userDrop = document.querySelector('.user-dropdown');

  // Toggle dropdown on icon click
userIcon.addEventListener('click', e => {
  e.stopPropagation();
  userDrop.classList.toggle('open');
});

// Close when clicking outside
document.addEventListener('click', () => {
  userDrop.classList.remove('open');
});

  
  // === Open Menu ===
  function openMenu() {
    menuOverlay.classList.remove('closing');
    menuOverlay.classList.add('open');
    menuToggle.classList.add('open');
  }

  // === Close Menu ===
  function closeMenu() {
    menuOverlay.classList.add('closing');

    setTimeout(() => {
      menuOverlay.classList.remove('closing');
      menuOverlay.classList.remove('open');
      menuToggle.classList.remove('open');
    }, 500); // matches the overlaySlideOut timing
  }

  // === Toggle hamburger menu ===
  menuToggle?.addEventListener('click', () => {
    if (menuOverlay.classList.contains('open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  closeBtn?.addEventListener('click', function (e) {
    e.preventDefault();
    closeMenu();
  });

  // Close menu if clicking outside menu-inner
  menuOverlay?.addEventListener('click', function (e) {
    if (!e.target.closest('.menu-inner')) {
      closeMenu();
    }
  });

  // Smooth close menu then navigate
  document.querySelectorAll('.menu-links a').forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (!href || href.startsWith('#')) return;

      e.preventDefault();
      closeMenu();

      // Navigate after overlay fully slides out
      setTimeout(() => {
        window.location.href = href;
      }, 500);
    });
  });

  // === Prevent auto-scroll to #footer on load ===
  window.addEventListener('load', function () {
    if (window.location.hash === "#footer") {
      history.replaceState(null, null, window.location.pathname);
      window.scrollTo({ top: 0, behavior: "instant" });
    }
  });

  // === Change navbar style on scroll ===
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.style.background = 'rgba(255, 255, 255, 0.95)';
      navbar.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
    } else {
      navbar.style.background = 'transparent';
      navbar.style.boxShadow = 'none';
    }
  });

  // === Initialize Slick Carousel for books ===
  if (typeof $ !== 'undefined' && $('.book-carousel').length) {
    $('.book-carousel').slick({
      slidesToShow: 3,
      centerMode: true,
      centerPadding: '0px',
      autoplay: true,
      autoplaySpeed: 3000,
      infinite: true,
      arrows: false, // 
      dots: true
    });
  }
});
