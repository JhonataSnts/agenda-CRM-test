<?php

namespace App\Controllers;
use App\Repositories\ContactRepository;

class ContactController
{
    public function index()
    {
        require '../config/database.php';

        $filters = [
            'nome' => $_GET['nome'] ?? '',
            'telefone' => $_GET['telefone'] ?? '',
            'email' => $_GET['email'] ?? '',
            'cpf' => $_GET['cpf'] ?? '',
            'cidade' => $_GET['cidade'] ?? '',
            'estado' => $_GET['estado'] ?? '',
        ];

        $contactRepository = new ContactRepository($pdo);

        $contatos = $contactRepository->listByUser($_SESSION['usuario_id'], $filters);

        $pageTitle = 'Agenda de Contatos';

        require_once '../views/contatos/index.php';
    }
}
