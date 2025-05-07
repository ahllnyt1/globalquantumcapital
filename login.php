<?php
require_once __DIR__ . '/init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = trim($_POST['username']);
  $p = $_POST['password'];
  $stmt = $pdo->prepare('SELECT * FROM users WHERE username=? OR email=?');
  $stmt->execute([$u, $u]);
  if ($user = $stmt->fetch()) {
    if (password_verify($p, $user['password'])) {
      $_SESSION['user'] = $user;
      header('Location: dashboard.php');
      exit;
    }
  }
  $error = 'Invalid credentials';
}

require_once __DIR__ . '/header.php';
?>

<div class="auth-modal">
  <!-- Left panel -->
  <div class="auth-left">
    <div>
      <h2>Welcome Back</h2>
      <p>Sign in to continue your journey with Global Quantum Capital.</p>
    </div>
    <div class="illustration">
      <img src="<?= BASE_URL ?>/assets/img/auth-left.png" alt="Crypto illustration">
    </div>
    <div class="auth-tabs">
      <button onclick="window.location='register.php'">Sign Up</button>
      <button class="active">Sign In</button>
    </div>
  </div>

  <!-- Right panel -->
  <div class="auth-right">
    <form method="post" class="auth-form">
      <h3>Sign In</h3>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <div class="form-group">
        <input name="username" placeholder="Username or Email" required>
      </div>
      <div class="form-group">
        <input name="password" type="password" placeholder="Password" required>
      </div>
      <button class="btn">Log In</button>
      <p class="switch">
        <a href="register.php">Don’t have an account? Sign Up</a>
      </p>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
