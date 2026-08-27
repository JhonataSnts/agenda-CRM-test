<?php

use App\Controllers\AuthController;

// Carrega helpers e autoload antes de chamar o controller.
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

// Inicia a sessao atual para que ela possa ser encerrada no logout.
session_start(); 

// Cria o controller de autenticacao.
$authController = new AuthController();

// Encerra a sessao e redireciona para a tela de login.
$authController->logout();
