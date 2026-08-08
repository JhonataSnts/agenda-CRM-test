<?php
session_start();

// Protege a ação: só usuários logados podem cadastrar contatos.
if (!isset($_SESSION['contato_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';

// Garante que este arquivo só processe envios do formulário.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

// Recebe e limpa os dados enviados pelo formulário.
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$cidadeId = $_POST['cidade_id'] ?? '';
$estadoId = $_POST['estado_id'] ?? '';

// Valida os campos obrigatórios antes de consultar ou salvar no banco.
if ($nome === '' || $telefone === '' || $email === '' || $cpf === '' || $cidadeId === '' || $estadoId === '') {
    die('Todos os campos são obrigatórios.');
}

// Confirma se a cidade escolhida pertence ao estado escolhido.
$stmt = $pdo->prepare('SELECT COUNT(*) FROM cidades WHERE id = :cidade_id AND estado_id = :estado_id');
$stmt->execute([
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
]);

$cidadePertenceAoEstado = $stmt->fetchColumn() > 0;

if (!$cidadePertenceAoEstado) {
    die('A cidade selecionada não pertence ao estado selecionado.');
}

// Prepara o cadastro do novo contato usando parâmetros para evitar SQL injection.
$sql = '
    INSERT INTO contatos (nome, telefone, email, cpf, cidade_id, estado_id)
    VALUES (:nome, :telefone, :email, :cpf, :cidade_id, :estado_id)
';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => $nome,
    ':telefone' => $telefone,
    ':email' => $email,
    ':cpf' => $cpf,
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
]);

// Após salvar, volta para a listagem.
header('Location: index.php');
exit;
