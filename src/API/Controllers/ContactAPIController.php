<?php

namespace App\API\Controllers;

use App\Repositories\ContactRepository;
use App\API\Middleware\AuthMiddleware;
use App\API\Helpers\APIResponse;
use PDO;

class ContactAPIController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index(): void
    {
        //Chama a segurança da API, se o token for inválido, o script morre la dentro com 401. Se for válido ele devolve o ID do usuário logado.
        $usuarioID = AuthMiddleware::handle();

        //Captura os filtros de busca da URL ($_GET) com fallback para string vazia
        $filters = [
            'nome' => $_GET['nome'] ?? '',
            'email' => $_GET['email'] ?? '',
            'telefone' => $_GET['telefone'] ?? '',
            'cpf' => $_GET['cpf'] ?? '',
            'cidade' => $_GET['cidade'] ?? '',
            'estado' => $_GET['estado'] ?? ''
        ];

        //Instanciar o repositorio de contatos
        $contactRepository = new ContactRepository($this->pdo);

        //Buscar contatos filtrados pertencentes apenas a esse usuario
        $contatos = $contactRepository->listByUser($usuarioID, $filters);
        
        //Retornar os contatos encontrados em formato JSON com status 200
        
        APIResponse::success($contatos, 200);
    }

    public function show(int $id): void
    {
        // 1. Chama o segurança para garantir o token válido e pegar o ID do dono
        $usuarioId = AuthMiddleware::handle();

        // 2. Instancia o repositório que já tem o método pronto (que arrumamos no schema do banco!)
        $contactRepository = new ContactRepository($this->pdo);
        
        // 3. Busca o contato cruzando o ID do contato com o ID do usuário logado
        $contato = $contactRepository->findByUser($id, $usuarioId);

        // 4. Se o banco retornar false (não achou ou não pertence a esse usuário), dá erro 404
        if (!$contato) {
            APIResponse::error('Contato não encontrado.', 404);
        }

        // 5. Se achou tudo certo, cospe os dados do contato com status 200 OK
        APIResponse::success($contato, 200);
    }

    //método store é o metodo responsavel por criar um novo contato no banco de dados
    public function store(): void
    {
        //chama o AuthMiddleware para garantir que o usuario está logado e descobrir seu ID
        $usuarioID = AuthMiddleware::handle();

        //Ler os dados do corpo em json usando php://input e json_decode().
        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        //Validar se os campos obrigatorios estão preenchidos
        if (!isset($body['nome']) || !isset($body['email'])) {
            APIResponse::error('Campos obrigatórios não fornecidos.', 400);
            return;
        }

        //utilizar as funções de validação de negocio
        $contactRepository = new ContactRepository($this->pdo);

        
    }
}