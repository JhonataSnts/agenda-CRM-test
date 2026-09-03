<?php

namespace App\API\Helpers;

class APIResponse 
{
    // Método para respostas de sucesso (Status padrão: 200)
    public static function success($data, int $status = 200) 
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'data'   => $data
        ]);
        exit;
    }

    // Método para respostas de erro (Status padrão: 400)
    public static function error(string $message, int $status = 400) 
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'error'  => $message
        ]);
        exit;
    }
}
