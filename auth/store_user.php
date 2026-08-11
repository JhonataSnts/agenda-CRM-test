<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if ($nome === '' || $email === '' || $senha === '') {
    die('Todos os campos são obrigatórios.');
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
$stmt->execute([':email' => $email]);

$usuarioExistente = $stmt->fetchColumn() > 0;

if ($usuarioExistente) {
    die('Já existe um usuário cadastrado com este email.');
}

$sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
$stmt = $pdo->prepare($sql);
$stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => password_hash($senha, PASSWORD_DEFAULT)]);

header('Location: login.php');
exit;