<?php
$title = 'Become a donor'; require 'includes/header.php';
$uid = $_SESSION['user_id'];
$msg = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bg = $_POST['blood_group'] ?? ''; $city = trim($_POST['city'] ?? ''); $phone = trim($_POST['phone'] ?? '');
    if (!in_array($bg, $GROUPS, true) || $city === '' || !preg_match('/^[0-9+\- ]{7,20}$/', $phone)) {
        $error = 'Choose a blood group, enter your city and a valid phone number.';
    } else {
        $pdo->prepare('INSERT INTO donors (user_id, blood_group, city, phone) VALUES (?,?,?,?)
                       ON DUPLICATE KEY UPDATE blood_group=VALUES(blood_group), city=VALUES(city), phone=VALUES(phone)')
            ->execute([$uid, $bg, $city, $phone]);
        $msg = 'Your donor details are saved.';
    }
}
$q = $pdo->prepare('SELECT * FROM donors WHERE user_id = ?'); $q->execute([$uid]); $d = $q->fetch() ?: [];
?>
<main class="card">
  <h2>Donor registration</h2>
  <p class="msg" style="background:var(--nav);border:2px solid var(--ink)">Before you register: donors are usually 18 to 65 years old, weigh at least 50 kg, are in good health, and wait about 3 months between donations. Rules vary, so confirm with your blood bank.</p>
  <?php if ($msg): ?><p class="msg ok"><?= e($msg) ?></p><?php endif; ?>
  <?php if ($error): ?><p class="msg err"><?= e($error) ?></p><?php endif; ?>
  <form method="post">
    <label>Blood group
      <select name="blood_group" required>
        <option value="">Select</option>
        <?php foreach ($GROUPS as $g): ?>
          <option value="<?= e($g) ?>" <?= (($d['blood_group'] ?? '') === $g) ? 'selected' : '' ?>><?= e($g) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>City<input name="city" required value="<?= e($d['city'] ?? '') ?>"></label>
    <label>Phone<input name="phone" required value="<?= e($d['phone'] ?? '') ?>"></label>
    <button class="btn-red" type="submit">Save details</button>
  </form>
  <?php if ($d): ?>
  <form method="post" action="remove_donor.php" onsubmit="return confirm('Remove your donor details?')">
    <button class="btn-dark" type="submit">Remove me as a donor</button>
  </form>
  <?php endif; ?>
</main>
<?php require 'includes/footer.php'; ?>
