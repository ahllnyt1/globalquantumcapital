<?php
// index.php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/header.php';
?>

<!-- HERO: Welcome with cover background -->
<section class="hero section-tab animate-up cover-1">
  <div class="cover-wrapper">
    <!-- replace with your hero image -->
    <img src="assets/img/your-hero-cover.jpg" alt="Hero cover">
  </div>
  <div class="container" style="text-align:center;">
    <h1 style="color: white;">Welcome to Global Quantum Capital</h1>
    <p class="lead" style="color: white;">The investing platform you can trust</p>
    <a
      href="<?= empty($_SESSION['user']) ? 'register.php' : 'dashboard.php' ?>"
      class="btn"
      style="color: white; margin-top: 1rem;"
    >
      <?= empty($_SESSION['user']) ? 'Start Investing' : 'Go to Dashboard' ?>
    </a>
  </div>
</section>

<!-- LIVE JOIN COUNTER with video background -->
<section class="section-tab animate-left cover-2">
  <!-- background video -->
  <video class="bg-video" autoplay muted loop playsinline>
    <source src="assets/video/your-cover.mp4" type="video/mp4">
    <!-- fallback image -->
    <img src="assets/img/your-fallback.jpg" alt="Fallback image">
  </video>
  <div class="container" style="text-align:center; position: relative; z-index:1;">
    <h2><span id="join-count">0</span> Users and Growing</h2>
    <p>Total Members Joined</p>
  </div>
</section>

<!-- FEATURE: Stablecoin Savings -->
<section class="section-tab animate-left">
  <div class="container">
    <h2>Earn up to 5% a Year on Dollar Stablecoins</h2>
    <p>
      Put your money to work with Global Quantum Earn, a crypto savings product
      perfect for anyone who wants decent returns without volatility.
    </p>
    <div class="media-placeholder" style="text-align:center; margin-top:1rem;">
      <!-- your video or image here -->
      <video style="max-width:300px;" autoplay loop muted controls>
        <source src="assets/video/stablecoin-video.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
    </div>
  </div>
</section>

<!-- FEATURE: Flex Investment -->
<section class="section-tab animate-right">
  <div class="container">
    <h2>The Best Flex Investment for Dollar Stablecoins</h2>
    <ul class="feature-list">
      <li>Earn passive income and hedge inflation</li>
      <li>Up to 5% daily interest</li>
      <li>Withdraw anytime</li>
      <li>Secure &amp; reliable, 24/7 support</li>
    </ul>
  </div>
</section>

<!-- REGULATION & SECURITY -->
<section class="section-tab animate-up small-section" style="display:flex; gap:2rem; flex-wrap:wrap;">
  <div style="flex:1; text-align:center;">
    <img src="assets/img/regulator-logo.png" style="width:80px" alt="Regulator logo">
    <h3>Regulated</h3>
    <p>Austria based &amp; European regulated crypto &amp; securities broker.</p>
    <a href="regulator.php" class="link">Read more</a>
  </div>
  <div style="flex:1; text-align:center;">
    <img src="assets/img/secure-logo.png" style="width:80px" alt="Safe & Secure logo">
    <h3>Safe &amp; Secure</h3>
    <p>Funds stored offline; fully compliant with EU data, IT &amp; AML standards.</p>
    <a href="safe.php" class="link">Read more</a>
  </div>
</section>

<!-- CTA: Join the Movement -->
<section class="hero section-tab animate-down">
  <div class="container" style="text-align:center;">
    <div class="media-placeholder" style="margin-bottom:1rem;">
      <!-- Upload your image here -->
    </div>
    <h2>Join the Crypto Movement</h2>
    <p>
      Invest in Bitcoin, Ethereum, and more—secure &amp; 24/7.<br>
      Earn 5% daily interest on your deposit.
    </p>
    <a
      href="<?= empty($_SESSION['user']) ? 'register.php' : 'dashboard.php' ?>"
      class="btn"
      style="margin-top: 1rem;"
    >
      <?= empty($_SESSION['user']) ? 'Get Started' : 'Go to Dashboard' ?>
    </a>
  </div>
</section>

<!-- CONTACT -->
<section class="section-tab animate-up">
  <div class="container">
    <h3>Contact Us</h3>
    <p>
      Email: <a href="mailto:globalquantum@gmail.com">globalquantum@gmail.com</a><br>
      Phone: +123456789<br>
      Telegram: <a href="https://t.me/GlobalQuantum">t.me/GlobalQuantum</a><br>
      Facebook: <a href="#">fb.com/GlobalQuantum</a><br>
      WhatsApp: <a href="#">wa.me/123456789</a>
    </p>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
