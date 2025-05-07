<?php
require 'auth.php';
require 'db.php';
$uid = $_SESSION['user']['id'];
// deposits + withdrawals + interests
$deps = $pdo->prepare("SELECT * FROM deposits WHERE user_id=? ORDER BY created_at DESC");
$deps->execute([$uid]);
$wds = $pdo->prepare("SELECT * FROM withdrawals WHERE user_id=? ORDER BY created_at DESC");
$wds->execute([$uid]);
$ints= $pdo->prepare("SELECT * FROM interests WHERE user_id=? ORDER BY created_at DESC");
$ints->execute([$uid]);
require 'header.php'; ?>
<div class="container">
  <h2>Notifications</h2>
  <div class="card-grid">
    <div class="card"><h3>Deposits</h3>
      <?php foreach($deps as $d) echo "<p>\${$d['amount']} — {$d['status']}</p>"; ?>
    </div>
    <div class="card"><h3>Withdrawals</h3>
      <?php foreach($wds as $w) echo "<p>\${$w['amount']} — {$w['status']}</p>"; ?>
    </div>
    <div class="card"><h3>Interests</h3>
      <?php foreach($ints as $i) echo "<p>+ \${$i['amount']}</p>"; ?>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
