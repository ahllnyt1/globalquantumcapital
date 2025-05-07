<?php require 'auth.php'; ?>
<?php require 'header.php'; ?>
<div class="container">
  <h2>Referral Program</h2>
  <p>Give your friends this link:</p>
  <input style="width:100%" readonly
    value="<?= BASE_URL ?>/register.php?ref=<?= $_SESSION['user']['referral_code'] ?>">
  <p>You earn $0.30 per signup + 5% of their deposits.</p>
</div>
<?php require 'footer.php'; ?>
