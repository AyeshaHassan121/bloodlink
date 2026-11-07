<?php
require_once 'includes/db.php';
require_login();
require_admin();
$_SESSION['csrf'] = $_SESSION['csrf'] ?? bin2hex(random_bytes(16));
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
    $id = (int)($_POST['id'] ?? 0);
    switch ($_POST['action'] ?? '') {
        case 'delete_request':
            $pdo->prepare('DELETE FROM blood_requests WHERE id = ?')->execute([$id]); $msg = 'Request deleted.'; break;
        case 'delete_donor':
            $pdo->prepare('DELETE FROM donors WHERE id = ?')->execute([$id]); $msg = 'Donor removed.'; break;
        case 'delete_user':
            if ($id !== (int)$_SESSION['user_id']) {
                $pdo->prepare('DELETE FROM users WHERE id = ? AND is_admin = 0')->execute([$id]); $msg = 'User deleted.';
            }
            break;
    }
}
function del_btn($action, $id) {
    return '<form method="post" onsubmit="return confirm(\'Delete this?\')">'
         . '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">'
         . '<input type="hidden" name="action" value="' . e($action) . '">'
         . '<input type="hidden" name="id" value="' . (int)$id . '">'
         . '<button class="btn-dark" type="submit">Delete</button></form>';
}
$users = $pdo->query('SELECT id, name, email, is_admin, created_at FROM users ORDER BY id DESC')->fetchAll();
$donors = $pdo->query('SELECT d.id, u.name, d.blood_group, d.city, d.phone FROM donors d JOIN users u ON u.id = d.user_id ORDER BY d.id DESC')->fetchAll();
$reqs = $pdo->query('SELECT id, patient_name, blood_group, city, contact, created_at FROM blood_requests ORDER BY id DESC')->fetchAll();
$title = 'Admin'; require 'includes/header.php';
?>
<main class="card wide">
  <h2>Admin panel</h2>
  <?php if ($msg): ?><p class="msg ok"><?= e($msg) ?></p><?php endif; ?>
  <p class="alt">Users: <strong><?= count($users) ?></strong> | Donors: <strong><?= count($donors) ?></strong> | Requests: <strong><?= count($reqs) ?></strong></p>
</main>

<main class="card wide">
  <h2>Users</h2>
  <div class="table-wrap"><table>
    <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th></th></tr>
    <?php foreach ($users as $u): ?>
      <tr><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td><td><?= $u['is_admin'] ? 'Admin' : 'User' ?></td>
          <td><?= e(substr($u['created_at'], 0, 10)) ?></td>
          <td><?= $u['is_admin'] ? '' : del_btn('delete_user', $u['id']) ?></td></tr>
    <?php endforeach; ?>
  </table></div>
</main>

<main class="card wide">
  <h2>Donors</h2>
  <div class="table-wrap"><table>
    <tr><th>Name</th><th>Blood group</th><th>City</th><th>Phone</th><th></th></tr>
    <?php foreach ($donors as $d): ?>
      <tr><td><?= e($d['name']) ?></td><td><?= e($d['blood_group']) ?></td><td><?= e($d['city']) ?></td><td><?= e($d['phone']) ?></td>
          <td><?= del_btn('delete_donor', $d['id']) ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$donors): ?><tr><td colspan="5">No donors yet.</td></tr><?php endif; ?>
  </table></div>
</main>

<main class="card wide">
  <h2>Blood requests</h2>
  <div class="table-wrap"><table>
    <tr><th>Patient</th><th>Blood group</th><th>City</th><th>Contact</th><th>Posted</th><th></th></tr>
    <?php foreach ($reqs as $r): ?>
      <tr><td><?= e($r['patient_name']) ?></td><td><?= e($r['blood_group']) ?></td><td><?= e($r['city']) ?></td><td><?= e($r['contact']) ?></td>
          <td><?= e(substr($r['created_at'], 0, 10)) ?></td><td><?= del_btn('delete_request', $r['id']) ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$reqs): ?><tr><td colspan="6">No requests yet.</td></tr><?php endif; ?>
  </table></div>
</main>
<?php require 'includes/footer.php'; ?>
