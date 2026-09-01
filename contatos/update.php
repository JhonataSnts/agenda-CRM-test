<?php

// Protege a atualizacao: somente usuarios logados podem atualizar contatos.
require_once '../auth/protect.php';

// Carrega conexao, helpers, validacoes e autoload usados pela atualizacao.
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;
use App\Repositories\ContactRepository;

// Cria o controller responsavel pelas acoes dos contatos.
$contactController = new ContactController;

// Processa o formulario de edicao enviado por POST.
$contactController->update();
