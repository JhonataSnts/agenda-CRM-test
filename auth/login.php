<?php

// Carrega o autoload para conseguir usar as classes dentro de src/.
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

// Carrega helpers usados pela view, como redirect() e e().
require_once '../helpers/functions.php';

// Inicia a sessao para o controller saber se o usuario ja esta logado.
session_start();

// Cria o controller responsavel pelas telas e acoes de autenticacao.
$authController = new AuthController();

// Mostra a tela de login.
$authController->showLogin();






