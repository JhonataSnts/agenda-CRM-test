<?php


require_once '../auth/protect.php';

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$cpf = onlyNumbers(trim($_POST['cpf'] ?? ''));
$cidadeId = (int) ($_POST['cidade_id'] ?? 0);
$estadoId = (int) ($_POST['estado_id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

if (isBlank($nome) || isBlank($telefone) || isBlank($email) || isBlank($cpf) || $cidadeId <= 0 || $estadoId <= 0) {
    die('Todos os campos são obrigatórios.');
}

if (!isValidEmail($email)) {
    die('O email informado é inválido.');
}

if (!isValidCpfLength($cpf)) {
    die('O CPF informado é inválido. Ele deve conter 11 dígitos.');
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
        email = :email,
        cpf = :cpf,
        cidade_id = :cidade_id,
        estado_id = :estado_id
    WHERE id = :id AND usuario_id = :usuario_id
';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => $nome,
    ':telefone' => $telefone,
    ':email' => $email,
    ':cpf' => $cpf,
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
    ':id' => $id,
    ':usuario_id' => $_SESSION['usuario_id']
]);

header('Location: index.php');
exit;
