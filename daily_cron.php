<?php
// daily_cron.php
require __DIR__ . '/db.php';

// 1) Guard: only run once per calendar day
$today = date('Y-m-d');
$checkStmt = $pdo->prepare("
  SELECT COUNT(*) 
    FROM interests 
   WHERE DATE(created_at) = ?
");
$checkStmt->execute([$today]);
$already = (int)$checkStmt->fetchColumn();
if ($already > 0) {
    // interest already applied today
    exit;
}

// 2) For every user, compute deposit‑based interest
$userStmt = $pdo->query("SELECT id FROM users");
while ($u = $userStmt->fetch(PDO::FETCH_ASSOC)) {
    $uid = $u['id'];

    // 3) Sum up all their APPROVED deposits
    $depStmt = $pdo->prepare("
      SELECT COALESCE(SUM(amount),0) 
        FROM deposits 
       WHERE user_id = ? 
         AND status  = 'approved'
    ");
    $depStmt->execute([$uid]);
    $totalDeposits = (float)$depStmt->fetchColumn();

    if ($totalDeposits <= 0) {
        // no deposits, skip interest
        continue;
    }

    // 4) 5% of total approved deposits
    $interest = $totalDeposits * 0.05;

    // 5) Log interest record
    $logStmt = $pdo->prepare("
      INSERT INTO interests (user_id, amount) 
           VALUES (?, ?)
    ");
    $logStmt->execute([$uid, $interest]);

    // 6) Credit the interest into their balance
    $updStmt = $pdo->prepare("
      UPDATE users 
         SET balance = balance + ? 
       WHERE id = ?
    ");
    $updStmt->execute([$interest, $uid]);
}
