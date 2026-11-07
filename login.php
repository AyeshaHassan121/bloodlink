<?php
$title = 'Sign in'; require 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = $pdo->prepare('SELECT * FROM users WHERE email = ?'); $q->execute([trim($_POST['email'] ?? '')]);
    $u = $q->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $u['id']; $_SESSION['name'] = $u['name'];
        header('Location: index.php'); exit;
    }
    $error = 'Incorrect email or password.';
}
?>
<main class="card">
  <h2>Sign in</h2>
  <?php if (isset($_GET['registered'])): ?><p class="msg ok">Account created. Sign in to continue.</p><?php endif; ?>
  <?php if ($error): ?><p class="msg err"><?= e($error) ?></p><?php endif; ?>
  <form method="post">
    <label>Email<input type="email" name="email" required></label>
    <label>Password<input type="password" name="password" required></label>
    <button class="btn-red" type="submit">Sign in</button>
  </form>
  <p class="alt">New here? <a href="signup.php">Create an account</a></p>
</main>
<?php require 'includes/footer.php'; ?>
