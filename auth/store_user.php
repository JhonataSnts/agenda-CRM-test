<?php

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Repositories\UserRepository;

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

$userRepository = new UserRepository($pdo);

if ($userRepository->emailExists($email)) {
    die('Já existe um usuário cadastrado com este email.');
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

if (!$userRepository->create($nome, $email, $senhaHash)) {
    die('Erro ao criar usuário. Tente novamente.');
}

redirect('login.php');
