<?php
require 'auth.php';
require 'db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']);
  $country=trim($_POST['country']);
  $email=trim($_POST['email']);
  $pdo->prepare("UPDATE users SET name=?,country=?,email=? WHERE id=?")
      ->execute([$name,$country,$email,$_SESSION['user']['id']]);
  $_SESSION['user']['name']=$name;
  $_SESSION['user']['country']=$country;
  $_SESSION['user']['email']=$email;
  $msg='Saved.';
}
require 'header.php'; ?>
<div class="container">
  <h2>Settings</h2>
  <?php if($msg) echo "<p>$msg</p>"; ?>
  <form method="post">
    <div class="form-group"><label>Name</label>
      <input name="name" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>"></div>
    <div class="form-group"><label>Country</label>
      <input name="country" value="<?= htmlspecialchars($_SESSION['user']['country']) ?>"></div>
    <div class="form-group"><label>Email</label>
      <input name="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>"></div>
    <button class="btn">Save</button>
  </form>
</div>
<?php require 'footer.php'; ?>
