<?php

// Protege a listagem: somente usuarios logados podem acessar os contatos.
require_once '../auth/protect.php';

// Carrega a conexao, helpers e autoload usados pelo fluxo desta pagina.
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;

// Cria o controller responsavel pelas acoes dos contatos.
$contactController = new ContactController;

// Mostra a listagem de contatos do usuario logado.
$contactController->index();
