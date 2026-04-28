<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

if ($username === ADMIN_USER && password_verify($password, ADMIN_PASS_HASH)) {
    $_SESSION['admin_logged'] = true;
    $_SESSION['admin_user'] = $username;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
}
?>
