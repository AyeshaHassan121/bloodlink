<?php
$title = 'Dashboard'; require 'includes/header.php';
$uid = $_SESSION['user_id'];
$q = $pdo->prepare('SELECT * FROM donors WHERE user_id = ?'); $q->execute([$uid]); $d = $q->fetch();
$r = $pdo->prepare('SELECT COUNT(*) FROM blood_requests WHERE user_id = ?'); $r->execute([$uid]); $count = $r->fetchColumn();
?>
<main class="card">
  <h2>Welcome, <?= e($_SESSION['name']) ?></h2>
  <?php if ($d): ?>
    <p class="msg ok">Donor profile: <?= e($d['blood_group']) ?>, <?= e($d['city']) ?>, <?= e($d['phone']) ?></p>
    <p class="alt"><a href="donor.php">Edit donor details</a></p>
  <?php else: ?>
    <p class="msg err">You are not registered as a donor yet.</p>
    <a class="btn-red" href="donor.php">Register as donor</a>
  <?php endif; ?>
  <p class="alt">Blood requests you posted: <strong><?= (int)$count ?></strong></p>
  <p class="alt"><a href="search.php">Find donors</a> | <a href="requests.php">Blood requests</a></p>
</main>
<?php require 'includes/footer.php'; ?>
