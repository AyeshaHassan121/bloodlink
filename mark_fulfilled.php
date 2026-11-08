<?php
require_once 'includes/db.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $pdo->prepare('UPDATE blood_requests SET fulfilled = 1 WHERE id = ? AND user_id = ?')->execute([$id, $_SESSION['user_id']]);
}
header('Location: requests.php');
exit;
