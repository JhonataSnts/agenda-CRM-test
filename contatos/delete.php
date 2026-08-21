<?php

require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Repositories\ContactRepository;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

$contactRepository = new ContactRepository($pdo);


if (!$contactRepository->deleteByUser($pdo, $_SESSION['usuario_id'], $id)) {
    die('Erro ao deletar contato');
}

redirect('index.php');
