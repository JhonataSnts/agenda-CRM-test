<?php

namespace App\API\Controllers;

use App\API\Helpers\APIResponse;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use PDO;

class AuthAPIController
{
    private PDO $pdo;

    // O construtor recebe a conexao pdo que o router vai injetar
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(): void
    {
        //Ler o stream bruto de json enviado pelo react/postman
        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        //Validar se os campos obrigatorios veio na requisição
        $email = $body['email'] ?? '';
        $password = $body['senha'] ?? '';
        
        //Se estiver vazio retornar um erro
        if (empty($email) || empty($password)) {
            APIResponse::error('E-mail e senha são obrigatórios.', 400);
        }

        //Instanciar o repositorio e buscar o usuario
        $userRepository = new UserRepository($this->pdo);
        $user = $userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user['senha'])) {
            APIResponse::error('E-mail ou senha inválidos.', 401);
        }

        // 5. Montar o payload do token (identificador do usuário + tempo de expiração)
        $payload = [
            'sub' => $user['id'],              // Dono do token
            'exp' => time() + (24 * 60 * 60)  // Expira em 24 horas (em segundos)
        ];

        // 6. Gerar o token assinado com a nossa constante JWT_SECRET definida no config/app.php
        $token = JWT::encode($payload, JWT_SECRET, 'HS256');

        // 7. Retornar os dados de sucesso e o Token para o front-end salvar
        APIResponse::success([
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'nome' => $user['nome'],
                'email' => $user['email']
            ]
        ], 200);
    }

    public function register(): void
    {
        //Ler o json bruto vindo do postman
        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        $name = $body['nome'] ?? '';
        $email = $body['email'] ?? '';
        $password = $body['senha'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            APIResponse::error('Nome, e-mail e senha são obrigatórios.', 400);
        }

        // 🔒 1. Criptografar a senha usando password_hash com o algoritmo padrão (bcrypt)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 🏛️ 2. Instanciar o UserRepository e rodar o método create que você me mostrou
        $userRepository = new UserRepository($this->pdo);
        $success = $userRepository->create($name, $email, $hashedPassword);

        // 3. Validar se a query funcionou no banco
        if (!$success) {
            APIResponse::error('Erro ao cadastrar o usuário. O e-mail pode já estar em uso.', 500);
        }

        // 🎉 4. Retornar a resposta clássica de sucesso REST com o status 201 Created
        APIResponse::success([
            'message' => 'Usuário cadastrado com sucesso!'
        ], 201);
        
    }
}