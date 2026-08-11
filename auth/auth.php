<?php 
session_start();

require_once '../config/database.php';
require_once '../helpers/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
    exit();
}
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $email = trim($email);
    $senha = trim($senha);

    if ($email === '' || $senha === '') {
        echo "Email e senha são obrigatórios";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        redirect('../contatos/index.php');
        exit();
    } else {
        echo "Email ou senha inválidos.";
        exit();
    }
