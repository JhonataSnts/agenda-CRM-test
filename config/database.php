<?php

// Dados usados para conectar no banco de dados MySQL.
$host = 'localhost';
$dbname = 'agenda_contatos';
$username = 'root';
$password = '';

// DSN informa para o PDO qual banco usar, em qual servidor conectar e qual charset utilizar.
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Cria a conexao com o banco usando PDO.
    $pdo = new PDO($dsn, $username, $password);

    // Faz o PDO lancar excecoes quando acontecer algum erro de SQL ou conexao.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Encerra a execucao se a conexao falhar.
    die("Erro na conexao com o banco de dados: " . $e->getMessage());
}
