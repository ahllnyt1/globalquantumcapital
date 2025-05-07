<?php
require 'auth.php';
require 'header.php';

// helper to mask emails
function maskEmail(string $email): string {
    if (strpos($email, '@') === false) return $email;
    [$user, $dom] = explode('@', $email, 2);
    return substr($user, 0, 4) . '****@' . $dom;
}

$uid = $_SESSION['user']['id'];

// 1) Totals
// a) deposits
$stmt = $pdo->prepare("
    SELECT COALESCE(SUM(amount),0)
      FROM deposits
     WHERE user_id = ? AND status = 'approved'
");
$stmt->execute([$uid]);
$totDep = (float)$stmt->fetchColumn();

// b) referrals (already stored)
$totRef = (float)$_SESSION['user']['referral_balance'];

// c) interests
$stmt = $pdo->prepare("
    SELECT COALESCE(SUM(amount),0)
      FROM interests
     WHERE user_id = ?
");
$stmt->execute([$uid]);
$totInt = (float)$stmt->fetchColumn();

// d) withdrawals
$stmt = $pdo->prepare("
    SELECT COALESCE(SUM(amount),0)
      FROM withdrawals
     WHERE user_id = ? AND status = 'approved'
");
$stmt->execute([$uid]);
$totWd = (float)$stmt->fetchColumn();

// compute the combined balance
$totalBalance = $totDep + $totRef + $totInt - $totWd;

// 2) Notifications lists
// deposits
$stmt = $pdo->prepare("
    SELECT amount,status,created_at
      FROM deposits
     WHERE user_id = ?
  ORDER BY created_at DESC
");
$stmt->execute([$uid]);
$deps = $stmt->fetchAll(PDO::FETCH_ASSOC);

// withdrawals
$stmt = $pdo->prepare("
    SELECT amount,status,created_at
      FROM withdrawals
     WHERE user_id = ?
  ORDER BY created_at DESC
");
$stmt->execute([$uid]);
$wds = $stmt->fetchAll(PDO::FETCH_ASSOC);

// interests
$stmt = $pdo->prepare("
    SELECT amount,created_at
      FROM interests
     WHERE user_id = ?
  ORDER BY created_at DESC
");
$stmt->execute([$uid]);
$ints = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3) Build rotating feed of random actions across all users
$sql = "
    SELECT u.email, d.amount, 'deposit'   AS type
      FROM deposits   d JOIN users u ON u.id=d.user_id
     WHERE d.status='approved'
    UNION
    SELECT u.email, w.amount, 'withdrawal' AS type
      FROM withdrawals w JOIN users u ON u.id=w.user_id
     WHERE w.status='approved'
    ORDER BY RAND()
    LIMIT 10
";
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$msgs = [];
foreach ($rows as $r) {
    $msgs[] = sprintf(
      "%s made a %s of $%s",
      maskEmail($r['email']),
      $r['type'],
      number_format($r['amount'],2)
    );
}
?>
<div class="container">
  <h2>Dashboard</h2>
  <div class="card-grid">
    <div class="card">
      <h3>Balance</h3>
      <p>$<?= number_format($totalBalance,2) ?></p>
    </div>

    <a href="deposit.php" class="card link-card">
      <h3>Total Deposits</h3>
      <p class="amount-green">$<?= number_format($totDep,2) ?></p>
    </a>

    <a href="withdraw.php" class="card link-card">
      <h3>Total Withdrawals</h3>
      <p class="amount-red">$<?= number_format($totWd,2) ?></p>
    </a>

    <div class="card">
      <h3>Total Interest Earned</h3>
      <p style="color: var(--clr-accent);">$<?= number_format($totInt,2) ?></p>
    </div>

    <div class="card">
      <h3>Referral Code</h3>
      <p>
        <input style="width:100%" readonly
               value="<?= BASE_URL ?>/register.php?ref=<?= 
                     $_SESSION['user']['referral_code'] ?>">
      </p>
    </div>

    <div class="card">
      <h3>Your Referrals</h3>
      <p>$<?= number_format($totRef,2) ?></p>
    </div>
  </div>
</div>

<hr class="page-break">

<div class="container notifications-section">
  <h2>Notifications</h2>
  <div class="card-grid">
    <div class="card">
      <h3>Deposits</h3>
      <?php foreach($deps as $d): ?>
        <p>$<?= number_format($d['amount'],2) ?> — 
          <?= htmlspecialchars($d['status']) ?></p>
      <?php endforeach; ?>
    </div>
    <div class="card">
      <h3>Withdrawals</h3>
      <?php foreach($wds as $w): ?>
        <p>$<?= number_format($w['amount'],2) ?> — 
          <?= htmlspecialchars($w['status']) ?></p>
      <?php endforeach; ?>
    </div>
    <div class="card">
      <h3>Interests</h3>
      <?php foreach($ints as $i): ?>
        <p>+ $<?= number_format($i['amount'],2) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div id="random-action" class="container random-action"></div>
<script>
  (function(){
    const msgs = <?= json_encode($msgs) ?>;
    let idx = 0;
    const el  = document.getElementById('random-action');
    if (!el || !msgs.length) return;
    function show(){
      el.textContent = msgs[idx];
      idx = (idx + 1) % msgs.length;
    }
    show();
    setInterval(show, 3000);
  })();
</script>

<?php require 'footer.php'; ?>
