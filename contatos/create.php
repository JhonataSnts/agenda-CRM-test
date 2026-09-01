<?php

use App\Controllers\ContactController;

// Protege o formulario: somente usuarios logados podem cadastrar contatos.
require_once '../auth/protect.php';

// Carrega a conexao, helpers e autoload usados pelo fluxo desta pagina.
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

// Cria o controller responsavel pelas acoes dos contatos.
$contactController = new ContactController;

// Mostra o formulario de novo contato.
$contactController->create();
