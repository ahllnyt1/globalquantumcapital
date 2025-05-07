<?php
require 'auth.php';
require 'db.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
  header("Location: dashboard.php");
  exit;
}

$msg = '';

// Approve Deposit
if (isset($_GET['approve_dep'])) {
  $id = intval($_GET['approve_dep']);
  $stmt = $pdo->prepare("SELECT * FROM deposits WHERE id = ?");
  $stmt->execute([$id]);
  $row = $stmt->fetch();

  if ($row && $row['status'] === 'pending') {
    $pdo->prepare("UPDATE deposits SET status = 'approved' WHERE id = ?")->execute([$id]);
    $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?")->execute([$row['amount'], $row['user_id']]);
    $msg = 'Deposit approved.';
  }
}

// Approve Withdrawal
if (isset($_GET['approve_wd'])) {
  $id = intval($_GET['approve_wd']);
  $stmt = $pdo->prepare("SELECT * FROM withdrawals WHERE id = ?");
  $stmt->execute([$id]);
  $row = $stmt->fetch();

  if ($row && $row['status'] === 'pending') {
    $pdo->prepare("UPDATE withdrawals SET status = 'approved' WHERE id = ?")->execute([$id]);
    $msg = 'Withdrawal approved.';
  }
}

// Handle user management pages
if (isset($_GET['page'])) {
  $page = $_GET['page'];

  if ($page === 'users') {
    require __DIR__ . '/admin_users.php';
    exit;
  }

  if ($page === 'edit_user' && isset($_GET['id'])) {
    require __DIR__ . '/edit_user.php';
    exit;
  }

  if ($page === 'delete_user' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id !== $_SESSION['user']['id']) {
      $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }
    header('Location: admin.php?page=users');
    exit;
  }
}

// Fetch pending deposits and withdrawals
$deps = $pdo->query("SELECT d.*, u.username FROM deposits d LEFT JOIN users u ON u.id = d.user_id WHERE d.status = 'pending'")->fetchAll();
$wds = $pdo->query("SELECT w.*, u.username FROM withdrawals w LEFT JOIN users u ON u.id = w.user_id WHERE w.status = 'pending'")->fetchAll();

require 'header.php';
?>

<div class="container">
  <h2>Admin Panel</h2>
  <h3><a href="admin.php?page=users">Manage Users</a></h3>

  <?php if ($msg): ?>
    <p style="color: green;"><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <h3>Pending Deposits</h3>
  <table border="1" cellpadding="4">
    <tr><th>ID</th><th>User</th><th>Amount</th><th>Action</th></tr>
    <?php foreach ($deps as $d): ?>
      <tr>
        <td><?= $d['id'] ?></td>
        <td><?= htmlspecialchars($d['username']) ?></td>
        <td>$<?= number_format($d['amount'], 2) ?></td>
        <td><a href="?approve_dep=<?= $d['id'] ?>">Approve</a></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h3>Pending Withdrawals</h3>
  <table border="1" cellpadding="4">
    <tr><th>ID</th><th>User</th><th>Amount</th><th>Address</th><th>Action</th></tr>
    <?php foreach ($wds as $w): ?>
      <tr>
        <td><?= $w['id'] ?></td>
        <td><?= htmlspecialchars($w['username']) ?></td>
        <td>$<?= number_format($w['amount'], 2) ?></td>
        <td><?= htmlspecialchars($w['wallet_address']) ?></td>
        <td><a href="?approve_wd=<?= $w['id'] ?>">Approve</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php require 'footer.php'; ?>
