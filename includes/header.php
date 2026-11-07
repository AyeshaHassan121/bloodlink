<?php
require_once __DIR__ . '/db.php';
$title = $title ?? 'BloodLink';
$public = ['index.php', 'login.php', 'signup.php'];
if (empty($_SESSION['user_id']) && !in_array(basename($_SERVER['SCRIPT_NAME']), $public)) {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> | BloodLink</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;700&family=Fredoka:wght@600;700&family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/validate.js" defer></script>
</head>
<body>
<div class="page">
  <nav class="nav">
    <a class="logo" href="index.php"><img src="assets/img/heartline.png" alt="BloodLink logo"></a>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="search.php">Find Donors</a></li>
      <li><a href="donor.php">Donate</a></li>
      <li><a href="requests.php">Requests</a></li>
<?php if (($_SESSION['is_admin'] ?? 0) == 1): ?><li><a href="admin.php">Admin</a></li><?php endif; ?>
    </ul>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <span class="nav-user"><a href="dashboard.php">Dashboard</a> <a class="btn-dark" href="logout.php">Log out</a></span>
    <?php else: ?>
      <a class="btn-dark" href="login.php">Sign in</a>
    <?php endif; ?>
  </nav>
