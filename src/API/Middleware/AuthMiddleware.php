<?php

namespace App\API\Middleware;

use App\API\Helpers\APIResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthMiddleware
{
    public static function handle(): int
    {
        // 1. Buscar o cabeçalho Authorization de todas as formas possíveis
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (empty($authHeader)) {
            APIResponse::error('Token não fornecido.', 401);
        }

        // 2. Isolar o token removendo o prefixo 'Bearer '
        $token = str_replace('Bearer ', '', $authHeader);

        // 3. Tentar decodificar dentro do bloco try/catch de segurança
        try {
            // Instancia o objeto Key com a nossa constante secreta e o algoritmo
            $key = new Key(JWT_SECRET, 'HS256');
            
            // Decodifica o token puro
            $decoded = JWT::decode($token, $key);

            // Se deu tudo certo, retorna o ID do usuário autenticado (convertido para inteiro)
            return (int) $decoded->sub;

        } catch (Exception $e) {
            // Se o token estiver expirado, adulterado ou inválido, cai aqui e barra o invasor
            APIResponse::error('Token inválido ou expirado.', 401);
        }
    }
}
