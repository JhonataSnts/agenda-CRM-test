<?php

// Garante que existe uma sessao ativa antes de verificar o login.
session_start();

// Se nao existe usuario na sessao, a pessoa nao esta autenticada.
if (!isset($_SESSION['usuario_id'])) {

    // Redireciona usuarios nao logados para a tela de login.
    header("Location: ../auth/login.php");
    exit();
}

