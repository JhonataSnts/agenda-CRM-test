<?php 

// Inicia a sessao para poder salvar o usuario logado depois do login.
session_start();

// Carrega funcoes auxiliares, validacoes e o autoload das classes.
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

// Cria o controller responsavel pela regra de autenticacao.
$authController = new AuthController();

// Processa o formulario de login enviado por POST.
$authController->login();
