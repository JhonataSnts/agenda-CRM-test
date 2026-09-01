<?php

// Protege a exclusao: somente usuarios logados podem excluir contatos.
require_once '../auth/protect.php';

// Carrega helpers e autoload usados pelo fluxo de exclusao.
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;

// Cria o controller responsavel pelas acoes dos contatos.
$contactController = new ContactController;

// Processa a exclusao enviada por POST.
$contactController->delete();
