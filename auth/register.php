<?php

// Carrega helpers e autoload para usar funcoes e controllers.
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

// Inicia a sessao para o controller verificar se o usuario ja esta logado.
session_start();

// Cria o controller responsavel pela autenticacao.
$authController = new AuthController();

// Mostra a tela de cadastro de usuario.
$authController->showRegister();




