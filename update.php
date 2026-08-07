<?php

session_start();

if (!isset($_SESSION['contato_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$cidadeId = (int) ($_POST['cidade_id'] ?? 0);
$estadoId = (int) ($_POST['estado_id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

if ($nome === '' || $telefone === '' || $cidadeId <= 0 || $estadoId <= 0) {
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
    UPDATE contatos
    SET nome = :nome,
        telefone = :telefone,
        cidade_id = :cidade_id,
        estado_id = :estado_id
    WHERE id = :id
';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => $nome,
    ':telefone' => $telefone,
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
    ':id' => $id,
]);

header('Location: index.php');
exit;
