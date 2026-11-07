<?php
$title = 'Blood requests'; require 'includes/header.php';
$msg = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['patient_name'] ?? ''); $bg = $_POST['blood_group'] ?? '';
    $city = trim($_POST['city'] ?? ''); $contact = trim($_POST['contact'] ?? ''); $details = trim($_POST['details'] ?? '');
    if ($name === '' || !in_array($bg, $GROUPS, true) || $city === '' || !preg_match('/^[0-9+\- ]{7,20}$/', $contact)) {
        $error = 'Enter the patient name, blood group, city and a valid contact number.';
    } else {
        $pdo->prepare('INSERT INTO blood_requests (user_id, patient_name, blood_group, city, contact, details) VALUES (?,?,?,?,?,?)')
            ->execute([$_SESSION['user_id'], $name, $bg, $city, $contact, substr($details, 0, 255)]);
        $msg = 'Your request is posted.';
    }
}
$rows = $pdo->query('SELECT patient_name, blood_group, city, contact, details, created_at FROM blood_requests ORDER BY created_at DESC')->fetchAll();
?>
<main class="card wide">
  <h2>Post a blood request</h2>
  <?php if ($msg): ?><p class="msg ok"><?= e($msg) ?></p><?php endif; ?>
  <?php if ($error): ?><p class="msg err"><?= e($error) ?></p><?php endif; ?>
  <form method="post">
    <div class="row2">
      <label>Patient name<input name="patient_name" required></label>
      <label>Blood group
        <select name="blood_group" required>
          <option value="">Select</option>
          <?php foreach ($GROUPS as $g): ?><option value="<?= e($g) ?>"><?= e($g) ?></option><?php endforeach; ?>
        </select>
      </label>
      <label>City<input name="city" required></label>
      <label>Contact number<input name="contact" required></label>
    </div>
    <label>Details (optional)<input name="details" maxlength="255"></label>
    <button class="btn-red" type="submit">Post request</button>
  </form>
</main>

<main class="card wide">
  <h2>All requests</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Patient</th><th>Blood group</th><th>City</th><th>Contact</th><th>Details</th><th>Posted</th></tr>
    <?php foreach ($rows as $r): ?>
      <tr><td><?= e($r['patient_name']) ?></td><td><?= e($r['blood_group']) ?></td><td><?= e($r['city']) ?></td>
          <td><?= e($r['contact']) ?></td><td><?= e($r['details']) ?></td><td><?= e(substr($r['created_at'], 0, 10)) ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="6">No requests yet.</td></tr><?php endif; ?>
  </table>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
