<?php $title = 'Dashboard'; require 'includes/header.php'; ?>
<main class="card">
  <h2>Welcome, <?= e($_SESSION['name']) ?></h2>
  <p class="alt">You are signed in. Donor registration, search and requests are coming next.</p>
</main>
<?php require 'includes/footer.php'; ?>
