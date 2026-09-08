<?php

require_once 'bootstrap.php';
use App\API\Router;

$router = new Router();

$router->post('/api/auth/register', 'AuthAPIController@register');
$router->post('/api/auth/login', 'AuthAPIController@login');

$router->get('/api/contatos', 'ContactController@index');
$router->post('/api/contatos', 'ContactController@store');
$router->get('/api/contatos/{id}', 'ContactController@show');
$router->put('/api/contatos/{id}', 'ContactController@update');
$router->delete('/api/contatos/{id}', 'ContactController@destroy');

$router->dispatch();
