<?php
// admin_users.php
// must be included from admin.php, so session + $pdo exist
?>
<h2>Manage All Users</h2>

<table border="1" cellpadding="6" style="width:100%;margin-bottom:20px;">
  <tr>
    <th>ID</th><th>Username</th><th>Email</th><th>Country</th>
    <th>Balance</th><th>Referral Bal.</th><th>Actions</th>
  </tr>
  <?php
  $users = $pdo->query("SELECT * FROM users ORDER BY id DESC");
  foreach($users as $u): ?>
  <tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['username']) ?></td>
    <td><?= htmlspecialchars($u['email']) ?></td>
    <td><?= htmlspecialchars($u['country']) ?></td>
    <td>$<?= number_format($u['balance'],2) ?></td>
    <td>$<?= number_format($u['referral_balance'],2) ?></td>
    <td>
      <a href="admin.php?page=edit_user&id=<?= $u['id'] ?>">Edit</a> |
      <a href="admin.php?page=delete_user&id=<?= $u['id'] ?>"
         onclick="return confirm('Delete user <?= $u['username'] ?>?')">Delete</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
