<?php
require_once __DIR__ . '/init.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // … your existing validation & registration logic …
}

require_once __DIR__ . '/header.php';
?>

<div class="auth-modal">
  <!-- Left panel -->
  <div class="auth-left">
    <div>
      <h2>Registration Bonus</h2>
      <p>Start to win with Global Quantum Capital—Get up to 5% daily interest!</p>
    </div>
    <div class="illustration">
      <img src="<?= BASE_URL ?>/assets/img/auth-left.png" alt="Crypto illustration">
    </div>
    <div class="auth-tabs">
      <button class="active">Sign Up</button>
      <button onclick="window.location='login.php'">Sign In</button>
    </div>
  </div>

  <!-- Right panel -->
  <div class="auth-right">
    <form method="post" class="auth-form">
      <h3>Create Account</h3>
      <?php foreach ($errors as $e): ?>
        <p class="error"><?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
      <div class="form-group">
        <input name="name" placeholder="Full Name" required>
      </div>
      <div class="form-group">
        <input name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input name="email" type="email" placeholder="Email Address" required>
      </div>
      <div class="form-group">
        <input name="country" placeholder="Country" required>
      </div>
      <div class="form-group">
        <input name="password" type="password" placeholder="Password (≥ 6 chars)" required>
      </div>
      <button class="btn">Sign Up</button>
      <p class="switch">
        <a href="login.php">Already have an account? Sign In</a>
      </p>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
