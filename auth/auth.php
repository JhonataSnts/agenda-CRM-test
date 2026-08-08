<?php 
session_start();

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    $email = trim($email);
    $cpf = trim($cpf);  

    if ($cpf === '' || $email === '') {
        echo "Email e cpf obrigatorios";
        exit();
    }

    if (strlen($cpf) !== 11) {
        echo "CPF deve ter 11 digitos";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM contatos WHERE cpf = :cpf AND email = :email");
    $stmt->execute(['cpf' => $cpf, 'email' => $email]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['contato_id'] = $user['id'];
        header("Location: ../contatos/index.php");
        exit();
    } else {
        echo "CPF ou email inválidos.";
    }
}