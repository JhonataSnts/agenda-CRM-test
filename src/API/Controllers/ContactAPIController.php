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
        // 1. Chamar o segurança para pegar o ID do usuário logado
        $usuarioId = AuthMiddleware::handle();

        // 2. Ler o JSON bruto vindo da requisição
        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        // 3. Capturar os campos enviados (adaptado para o português/padrão que você usa)
        $nome        = $body['nome'] ?? '';
        $telefone    = $body['telefone'] ?? '';
        $email       = $body['email'] ?? '';
        $cpf         = $body['cpf'] ?? '';
        $cidadeId    = (int) ($body['cidade_id'] ?? 0);
        $estadoId    = (int) ($body['estado_id'] ?? 0);
        $categoriaId = (int) ($body['categoria_id'] ?? 0);

        // 4. Validação básica de campos obrigatórios
        if (empty($nome) || $cidadeId <= 0 || $estadoId <= 0 || $categoriaId <= 0) {
            APIResponse::error('Nome, cidade, estado e categoria são obrigatórios.', 400);
        }

                // 🏛️ 5. Instanciar o repositório
        $contactRepository = new ContactRepository($this->pdo);

        // 🔒 6. Validação de negócio (continua igual)
        if (!$contactRepository->cityBelongsToState($cidadeId, $estadoId)) {
            APIResponse::error('A cidade selecionada não pertence ao estado informado.', 400);
        }

        // 💾 7. AJUSTE AQUI: Monte o array exatamente como o seu repositório espera ler na linha 85
        $data = [
            'nome'         => $nome,
            'telefone'     => $telefone,
            'email'        => $email,
            'cpf'          => $cpf,
            'cidadeId'    => $cidadeId,
            'estadoId'    => $estadoId,
            'categoriaId' => $categoriaId
        ];

        // Passa o array de dados único para o método create
        $success = $contactRepository->create($usuarioId, $data);

        if (!$success) {
            APIResponse::error('Erro ao salvar o contato no banco de dados.', 500);
        }


        // 🎉 8. Sucesso absoluto! Retorna status 201 Created
        APIResponse::success([
            'message' => 'Contato criado com sucesso!'
        ], 201);
    }

    public function update(int $id): void
    {
        //Garantir que o token é valido e pegar o ID do usuário
        $usuarioId = AuthMiddleware::handle();

        //Ler o JSON da requisição
        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        //Capturar os campos enviados (adaptado para o português/padrão que você usa)
        $nome        = $body['nome'] ?? '';
        $telefone    = $body['telefone'] ?? '';
        $email       = $body['email'] ?? '';
        $cpf         = $body['cpf'] ?? '';
        $cidadeId    = (int) ($body['cidade_id'] ?? 0);
        $estadoId    = (int) ($body['estado_id'] ?? 0);
        $categoriaId = (int) ($body['categoria_id'] ?? 0);

        //Validação básica de campos obrigatórios
        
        if (empty($nome) || $cidadeId <= 0 || $estadoId <= 0 || $categoriaId <= 0) {
            APIResponse::error('Nome, cidade, estado e categoria são obrigatórios.', 400);
        }

        //Instanciar o repositório 
        $contactRepository = new ContactRepository($this->pdo);

        //validação de negocio
        if (!$contactRepository->cityBelongsToState($cidadeId, $estadoId)) {
            APIResponse::error('A cidade selecionada não pertence ao estado informado.', 400);
        }

        //Montar o array de dados
        $data = [
            'nome'         => $nome,
            'telefone'     => $telefone,
            'email'        => $email,
            'cpf'          => $cpf,
            'cidadeId'    => $cidadeId,
            'estadoId'    => $estadoId,
            'categoriaId' => $categoriaId
        ];

        //Assinatura 
        $success = $contactRepository->updateByUser($usuarioId, $id, $data);

        //Se o banco retornar false (indica que o contato não existe ou não pertence a esse usuário)
        if (!$success) {
            APIResponse::error('Contato não encontrado ou você não tem permissão para alterá-lo.', 404);
        }

        APIResponse::success([
            'message' => 'Contato atualizado com sucesso!'
        ], 200);
    }

    public function destroy(int $id): void
    {
        //Garantir que o token é valido e pegar o ID do usuário
        $usuarioId = AuthMiddleware::handle();

        //Instanciar o repositório
        $contactRepository = new ContactRepository($this->pdo);

        //Tentar excluir o contato que pertence ao usuário logado
        $success = $contactRepository->deleteByUser($usuarioId, $id);

        //Se o banco retornar false (indica que o contato não existe ou não pertence a esse usuário)
        if (!$success) {
            APIResponse::error('Contato não encontrado ou você não tem permissão para excluí-lo.', 404);
        }

        //Se chegou aqui, deu tudo certo!
        APIResponse::success([
            'message' => 'Contato excluído com sucesso!'
        ], 200);
    }

}