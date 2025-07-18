<?php
session_start();
require_once '../db/config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

$response = ['success' => false];

if ($email && $password) {
    $stmt = $pdo->prepare('SELECT role, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $response['success'] = true;
        $_SESSION['role'] = $user['role'];
        $response['role'] = $user['role'];
    }
}

echo json_encode($response);