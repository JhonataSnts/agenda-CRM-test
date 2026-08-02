<?php

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$cidadeId = $_POST['cidade_id'] ?? '';
$estadoId = $_POST['estado_id'] ?? '';

if ($nome === '' || $telefone === '' || $cidadeId === '' || $estadoId === '') {
    die('Todos os campos são obrigatórios.');
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM cidades WHERE id = :cidade_id AND estado_id = :estado_id');
$stmt->execute([
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
]);

$cidadePertenceAoEstado = $stmt->fetchColumn() > 0;

if (!$cidadePertenceAoEstado) {
    die('A cidade selecionada não pertence ao estado selecionado.');
}

$sql = '
    INSERT INTO contatos (nome, telefone, cidade_id, estado_id)
    VALUES (:nome, :telefone, :cidade_id, :estado_id)
';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => $nome,
    ':telefone' => $telefone,
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
]);

header('Location: index.php');
exit;
