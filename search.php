<?php
$title = 'Find donors'; require 'includes/header.php';
$bg = $_GET['blood_group'] ?? ''; $city = trim($_GET['city'] ?? '');
$sql = 'SELECT u.name, d.blood_group, d.city, d.phone FROM donors d JOIN users u ON u.id = d.user_id WHERE 1=1';
$args = [];
if (in_array($bg, $GROUPS, true)) { $sql .= ' AND d.blood_group = ?'; $args[] = $bg; }
if ($city !== '') { $sql .= ' AND d.city LIKE ?'; $args[] = '%' . $city . '%'; }
$sql .= ' ORDER BY d.created_at DESC';
$q = $pdo->prepare($sql); $q->execute($args); $rows = $q->fetchAll();
?>
<main class="card wide">
  <h2>Find donors</h2>
  <form method="get" class="row">
    <label>Blood group
      <select name="blood_group">
        <option value="">Any</option>
        <?php foreach ($GROUPS as $g): ?>
          <option value="<?= e($g) ?>" <?= $bg === $g ? 'selected' : '' ?>><?= e($g) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>City<input name="city" value="<?= e($city) ?>"></label>
    <div><button class="btn-red" type="submit">Search</button></div>
  </form>
  <div class="table-wrap">
  <table>
    <tr><th>Name</th><th>Blood group</th><th>City</th><th>Phone</th></tr>
    <?php foreach ($rows as $r): ?>
      <tr><td><?= e($r['name']) ?></td><td><?= e($r['blood_group']) ?></td><td><?= e($r['city']) ?></td><td><?= e($r['phone']) ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="4">No donors found. Try a different blood group or city.</td></tr><?php endif; ?>
  </table>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
