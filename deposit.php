<?php
require 'auth.php';
require 'db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $amt=floatval($_POST['amount']);
  if($amt<20) $msg='Minimum $20';
  else {
    $ins=$pdo->prepare("INSERT INTO deposits(user_id,amount) VALUES(?,?)");
    $ins->execute([$_SESSION['user']['id'],$amt]);
    $msg='Deposit request pending approval.';
  }
}
require 'header.php'; ?>
<div class="container">
  <h2>Deposit Funds</h2>
  <?php if($msg) echo "<p>$msg</p>"; ?>
  <form method="post">
    <div class="form-group">
      <label>Amount ($)</label>
      <input type="number" name="amount" min="20" required>
    </div>
    <p>Use TRX wallet: <code>TSFNqjYTuPf7u8oEhkq6FUJvri1v85yqsQ</code></p>
    <button class="btn">Submit Deposit</button>
  </form>
</div>
<?php require 'footer.php'; ?>
