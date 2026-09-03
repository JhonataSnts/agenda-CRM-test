<?php

// Protege o cadastro: somente usuarios logados podem salvar contatos.
require_once '../auth/protect.php';

// Carrega conexao, helpers, validacoes e autoload usados pelo cadastro.
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;
use App\Repositories\ContactRepository;

// Cria o controller responsavel pelas acoes dos contatos.
$contactController = new ContactController;

// Processa o formulario de cadastro enviado por POST.
$contactController->store();
