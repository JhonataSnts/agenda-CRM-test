<?php

require_once '../vendor/autoload.php';
require_once '../config/app.php';
require_once '../config/database.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Teste temporário
\App\API\Helpers\APIResponse::success(['mensagem' => 'A API está funcionando']);


