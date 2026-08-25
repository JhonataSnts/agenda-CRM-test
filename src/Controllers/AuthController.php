<?php

namespace App\Controllers;
use App\Repositories\UserRepository;

class AuthController
{
    public function showLogin()
    {
        if (isset($_SESSION['usuario_id'])) {
            redirect('../contatos/index.php');
            exit();
        } 
        $pageTitle = 'Login - Agenda de Contatos';
        require_once '../views/auth/login.php';
    }

    public function showRegister()
    {
        if (isset($_SESSION['usuario_id'])) {
            redirect('../contatos/index.php');
            exit;
        }
        $pageTitle = 'Cadastre-se - Agenda de Contatos';
        require_once '../views/auth/register.php';
    }

    public function login() 
    {
        require '../config/database.php';
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
    }
}