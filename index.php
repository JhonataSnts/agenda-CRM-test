<?php

require_once 'config/database.php';

$nome = $_GET['nome'] ?? '';
$telefone = $_GET['telefone'] ?? '';
$cidade = $_GET['cidade'] ?? '';
$estado = $_GET['estado'] ?? '';

$sql = "
    SELECT
        contatos.id,
        contatos.nome,
        contatos.telefone,
        cidades.nome AS cidade_nome,
        estados.nome AS estado_nome
    FROM contatos
    INNER JOIN cidades
        ON cidades.id = contatos.cidade_id
    INNER JOIN estados
        ON estados.id = contatos.estado_id
    WHERE contatos.nome LIKE :nome
        AND contatos.telefone LIKE :telefone
        AND cidades.nome LIKE :cidade
        AND estados.nome LIKE :estado
    ORDER BY contatos.nome ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => "%$nome%",
    ':telefone' => "%$telefone%",
    ':cidade' => "%$cidade%",
    ':estado' => "%$estado%",
]);

$contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
