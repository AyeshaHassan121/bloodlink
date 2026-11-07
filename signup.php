<?php
$title = 'Sign up'; require 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? ''); $pass = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        $error = 'Enter your name, a valid email and a password of at least 6 characters.';
    } else {
        $q = $pdo->prepare('SELECT id FROM users WHERE email = ?'); $q->execute([$email]);
        if ($q->fetch()) { $error = 'That email is already registered.'; }
        else {
            $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)')
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            header('Location: login.php?registered=1'); exit;
        }
    }
}
?>
<main class="card">
  <h2>Create your account</h2>
  <?php if ($error): ?><p class="msg err"><?= e($error) ?></p><?php endif; ?>
  <form method="post">
    <label>Full name<input name="name" required value="<?= e($_POST['name'] ?? '') ?>"></label>
    <label>Email<input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></label>
    <label>Password<input type="password" name="password" minlength="6" required></label>
    <button class="btn-red" type="submit">Sign up</button>
  </form>
  <p class="alt">Already have an account? <a href="login.php">Sign in</a></p>
</main>
<?php require 'includes/footer.php'; ?>
