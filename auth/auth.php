<?php 
session_start();

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Repositories\UserRepository;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
    exit();
}
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $email = trim($email);
    $senha = trim($senha);

    if (isBlank($email) || isBlank($senha)) {
        echo "Email e senha são obrigatórios";
        exit();
    }

    if (!isValidEmail($email)) {
        echo "O email informado é inválido.";
        exit();
    }

    $userRepository = new UserRepository($pdo);

    $user = $userRepository->findByEmail($email);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        redirect('../contatos/index.php');
        exit();
    } else {
        echo "Email ou senha inválidos.";
        exit();
    }
