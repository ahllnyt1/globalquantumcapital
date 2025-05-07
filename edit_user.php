<?php
// edit_user.php
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if(!$user) {
  echo "<p>User not found.</p>";
  return;
}
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
  // collect + validate
  $name    = trim($_POST['name']);
  $email   = trim($_POST['email']);
  $country = trim($_POST['country']);
  $balance = floatval($_POST['balance']);
  $rbal    = floatval($_POST['referral_balance']);
  // Optionally update password
  $pwd     = $_POST['password'];
  // update query
  $pdo->prepare(
    "UPDATE users 
       SET name=?, email=?, country=?, balance=?, referral_balance=?
     WHERE id=?"
  )->execute([$name,$email,$country,$balance,$rbal,$id]);
  if($pwd){
    $hash = password_hash($pwd,PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE users SET password=? WHERE id=?")
        ->execute([$hash,$id]);
  }
  header("Location: admin.php?page=users");
  exit;
}
?>

<h2>Edit User #<?= $id ?></h2>
<form method="post" style="max-width:400px;">
  <?php foreach($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>

  <div class="form-group">
    <label>Name</label>
    <input name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
  </div>
  <div class="form-group">
    <label>Email</label>
    <input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required>
  </div>
  <div class="form-group">
    <label>Country</label>
    <input name="country" value="<?= htmlspecialchars($user['country']) ?>" required>
  </div>
  <div class="form-group">
    <label>Balance ($)</label>
    <input name="balance" type="number" step="0.01" value="<?= $user['balance'] ?>" required>
  </div>
  <div class="form-group">
    <label>Referral Balance ($)</label>
    <input name="referral_balance" type="number" step="0.01" value="<?= $user['referral_balance'] ?>" required>
  </div>
  <div class="form-group">
    <label>New Password <small>(leave blank to keep)</small></label>
    <input name="password" type="password">
  </div>
  <button class="btn">Save Changes</button>
  <a class="btn" href="admin.php?page=users">Cancel</a>
</form>
