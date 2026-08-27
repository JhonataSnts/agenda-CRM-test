<?php

// Carrega helpers, validacoes e autoload das classes.
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

// Cria o controller responsavel pelo cadastro.
$authController = new AuthController();

// Processa o formulario de cadastro de usuario.
$authController->register();

