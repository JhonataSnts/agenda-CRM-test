<?php

namespace App\Controllers;

class AuthController
{
    public function showLogin()
    {
        if (isset($_SESSION['usuario_id'])) {
            redirect('../contatos/index.php');
            exit();
        } 
        $pageTitle = 'Faça login - Agenda de Contatos';
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
}