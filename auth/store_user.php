<?php

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('register.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (isBlank($nome) || isBlank($email) || isBlank($senha)) {
    die('Todos os campos são obrigatórios.');
}

if (!isValidEmail($email)) {
    die('O email informado é inválido.');
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

redirect('login.php');
exit;