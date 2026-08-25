<?php

namespace App\Controllers;

class AuthController
{
    public function showLogin()
    {
        if (isset($_SESSION['usuario_id'])) {
        redirect('../contatos/index.php');
        exit();
        } else {
            require_once '../views/auth/login.php';
        }
        
    }
}