<?php
require 'auth.php';
require 'db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $amt= floatval($_POST['amount']);
  $addr= htmlspecialchars($_POST['wallet']);
  if($amt<10) $msg='Minimum $10';
  elseif($amt>$_SESSION['user']['balance']) $msg='Insufficient balance';
  else {
    $ins = $pdo->prepare(
      "INSERT INTO withdrawals(user_id,amount,wallet_address) VALUES(?,?,?)"
    );
    $ins->execute([$_SESSION['user']['id'],$amt,$addr]);
    // deduct immediately
    $_SESSION['user']['balance'] -= $amt;
    $pdo->prepare("UPDATE users SET balance=? WHERE id=?")
        ->execute([$_SESSION['user']['balance'],$_SESSION['user']['id']]);
    $msg='Withdrawal request pending approval.';
  }
}
require 'header.php'; ?>
<div class="container">
  <h2>Withdraw Funds</h2>
  <?php if($msg) echo "<p>$msg</p>"; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label>Amount ($)</label>
      <input type="number" name="amount" min="10" required>
    </div>
    <div class="form-group">
      <label>USDT TRC20 Address</label>
      <input name="wallet" required>
    </div>
    <button class="btn">Request Withdrawal</button>
  </form>
</div>
<?php require 'footer.php'; ?>
