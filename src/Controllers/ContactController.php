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

    public function store()
    {
        require '../config/database.php';

        // Garante que este arquivo só processe envios do formulário.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: create.php');
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $cpf = onlyNumbers(trim($_POST['cpf'] ?? ''));
        $cidadeId = $_POST['cidade_id'] ?? '';
        $estadoId = $_POST['estado_id'] ?? '';
        $categoriaId = $_POST['categoria_id'] ?? '';


        // Valida os campos obrigatórios antes de consultar ou salvar no banco.
        if (isBlank($nome) || isBlank($telefone) || isBlank($email) || isBlank($cpf) || isBlank($cidadeId) || isBlank($estadoId) || isBlank($categoriaId)) {
            die('Todos os campos são obrigatórios.');
        }

        if (!isValidEmail($email)) {
            die('O email informado é inválido.');
        }



        if (!isValidCpfLength($cpf)) {
            die('O CPF informado é inválido. Ele deve conter 11 dígitos.');
        }

        $contactRepository = new ContactRepository($pdo);

        $cidadePertenceAoEstado = $contactRepository->cityBelongsToState($cidadeId, $estadoId);

        if (!$cidadePertenceAoEstado) {
            die('A cidade selecionada não pertence ao estado selecionado.');
        }

        $data = [
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email,
            'cpf' => $cpf,
            'cidadeId' => $cidadeId,
            'estadoId' => $estadoId,
            'categoriaId' => $categoriaId,
        ];

        // Prepara o cadastro do novo contato usando parâmetros para evitar SQL injection.
        if (!$contactRepository->create($_SESSION['usuario_id'], $data)) {
            die('Erro ao cadastrar contato.');
        }

        // Após salvar, volta para a listagem.
        redirect('index.php');
    }
}
