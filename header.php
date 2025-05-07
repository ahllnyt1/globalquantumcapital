<?php
// header.php
// — init.php must already have been required before this
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Global Quantum Capital</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- main stylesheet -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <!-- auth modal (login/register) styles -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>
<body>
<header class="site-header">
  <div class="header-inner container">
    <div class="site-logo">
      <a href="<?= BASE_URL ?>/index.php">
        <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="GQC Logo" height="40">
      </a>
    </div>
    <nav class="site-nav">
      <?php if (empty($_SESSION['user'])): ?>
        <a href="<?= BASE_URL ?>/index.php">Home</a>
        <a href="<?= BASE_URL ?>/register.php">Sign Up</a>
        <a href="<?= BASE_URL ?>/login.php">Login</a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/index.php">Home</a>
        <a href="<?= BASE_URL ?>/dashboard.php">Dashboard</a>
        <a href="<?= BASE_URL ?>/deposit.php">Deposit</a>
        <a href="<?= BASE_URL ?>/withdraw.php">Withdraw</a>
        <a href="<?= BASE_URL ?>/referral.php">Referral</a>
        <a href="<?= BASE_URL ?>/notifications.php">Notifications</a>
        <a href="<?= BASE_URL ?>/settings.php">Settings</a>
        <?php if ($_SESSION['user']['is_admin']): ?>
          <a href="<?= BASE_URL ?>/admin.php">Admin Panel</a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/logout.php">Logout</a>
      <?php endif; ?>

      <!-- Dark‑mode toggle -->
      <button id="dark-mode-toggle" class="dark-toggle" aria-label="Toggle dark mode">🌓</button>
    </nav>
  </div>
</header>
<main>
