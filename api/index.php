<?php

require_once 'bootstrap.php';
use App\API\Router;

$router = new Router();

$router->post('/api/auth/register', 'AuthAPIController@register');
$router->post('/api/auth/login', 'AuthAPIController@login');

$router->get('/api/contatos', 'ContactAPIController@index');
$router->post('/api/contatos', 'ContactAPIController@store');
$router->get('/api/contatos/{id}', 'ContactAPIController@show');
$router->put('/api/contatos/{id}', 'ContactAPIController@update');
$router->delete('/api/contatos/{id}', 'ContactAPIController@destroy');

$router->dispatch();
