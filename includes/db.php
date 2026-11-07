<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bloodlink;charset=utf8mb4', 'blood_user', 'blood_pass', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed.');
}
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function require_login() {
    if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
}
$GROUPS = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
