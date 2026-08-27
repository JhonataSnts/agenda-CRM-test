<?php

namespace App\Controllers;
use App\Repositories\ContactRepository;
use PDO;

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

    public function create() 
    {
        require '../config/database.php';

        $estados = $pdo->query('SELECT id, nome, uf FROM estados ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
        $cidades = $pdo->query('SELECT id, nome, estado_id FROM cidades ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
        $categorias = $pdo->query('SELECT id, nome FROM categorias ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);

        $pageTitle = 'Novo Contato';

        require_once '../views/contatos/create.php';
    }
}
