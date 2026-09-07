<?php

namespace App\API;

use App\API\Helpers\APIResponse;

class Router
{
    // Armazena as rotas agrupadas por método HTTP: $routes['GET']['pattern'] = 'Handler'
    private array $routes = [];

    // Atalho para registrar rotas GET
    public function get(string $route, string $handler): void
    {
        $this->addRoute('GET', $route, $handler);
    }

    // Atalho para registrar rotas POST
    public function post(string $route, string $handler): void
    {
        $this->addRoute('POST', $route, $handler);
    }

    // Atalho para registrar rotas PUT
    public function put(string $route, string $handler): void
    {
        $this->addRoute('PUT', $route, $handler);
    }

    // Atalho para registrar rotas DELETE
    public function delete(string $route, string $handler): void
    {
        $this->addRoute('DELETE', $route, $handler);
    }

    // Método central que processa a rota e armazena no array
    private function addRoute(string $method, string $route, string $handler): void
    {
        // 1. Converte {id} para a expressão regular (\d+)
        $pattern = str_replace('{id}', '(\d+)', $route);

        // 2. Adiciona as âncoras de início (#^) e fim ($#) para o casamento exato da URL
        $pattern = '#^' . $pattern . '$#';

        // 3. Salva na matriz de rotas
        $this->routes[$method][$pattern] = $handler;
    }

    // Lê a requisição atual do servidor e dispara o Controller correto
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Pega apenas o caminho limpo da URL, ignorando parâmetros GET (?ordem=nome, etc.)
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Se não existirem rotas registradas para este método HTTP
        if (!isset($this->routes[$method])) {
            APIResponse::error('Method not allowed', 405);
        }

        // Varre as rotas registradas para o método HTTP atual
        foreach ($this->routes[$method] as $pattern => $handler) {
            
            // Verifica se a URL digitada bate com a Expressão Regular da rota
            if (preg_match($pattern, $url, $matches)) {
                
                // Remove o primeiro item de $matches (que é a URL inteira) e deixa só os parâmetros (ex: o ID)
                array_shift($matches);

                // Separa a string "ContactController@show" em Controller e Método
                parts = explode('@', $handler);
                $controllerName = "App\\API\\Controllers\\" . parts[0];
                $methodName = parts[1];

                // Verifica se a classe do Controller realmente existe
                if (!class_exists($controllerName)) {
                    APIResponse::error("Controller {$parts[0]} não encontrado", 500);
                }

                // Instancia o controller dinamicamente (passando a conexão PDO global se necessário)
                global $pdo; 
                $controllerInstance = new $controllerName($pdo);

                // Verifica se o método existe dentro do Controller
                if (!method_exists($controllerInstance, $methodName)) {
                    APIResponse::error("Método {$methodName} não encontrado no Controller", 500);
                }

                // Executa o método do controller passando os parâmetros capturados (como o ID)
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }

        // Se o loop terminar e nenhuma rota bater com a URL
        APIResponse::error('Not found', 404);
    }
}
