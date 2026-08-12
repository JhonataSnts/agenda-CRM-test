<?php


// Protege a ação: só usuários logados podem cadastrar contatos.
require_once '../auth/protect.php';

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';

// Garante que este arquivo só processe envios do formulário.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

// Recebe e limpa os dados enviados pelo formulário.
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$cpf = onlyNumbers(trim($_POST['cpf'] ?? ''));
$cidadeId = $_POST['cidade_id'] ?? '';
$estadoId = $_POST['estado_id'] ?? '';

// Valida os campos obrigatórios antes de consultar ou salvar no banco.
if (isBlank($nome) || isBlank($telefone) || isBlank($email) || isBlank($cpf) || isBlank($cidadeId) || isBlank($estadoId)) {
    die('Todos os campos são obrigatórios.');
}

if (!isValidEmail($email)) {
    die('O email informado é inválido.');
}



if (!isValidCpfLength($cpf)) {
    die('O CPF informado é inválido. Ele deve conter 11 dígitos.');
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
    INSERT INTO contatos (nome, telefone, email, cpf, cidade_id, estado_id, usuario_id)
    VALUES (:nome, :telefone, :email, :cpf, :cidade_id, :estado_id, :usuario_id)
';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => $nome,
    ':telefone' => $telefone,
    ':email' => $email,
    ':cpf' => $cpf,
    ':cidade_id' => $cidadeId,
    ':estado_id' => $estadoId,
    ':usuario_id' => $_SESSION['usuario_id'],
]);

// Após salvar, volta para a listagem.
header('Location: index.php');
exit;
