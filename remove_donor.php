<?php
require_once 'includes/db.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare('DELETE FROM donors WHERE user_id = ?')->execute([$_SESSION['user_id']]);
}
header('Location: dashboard.php');
exit;
