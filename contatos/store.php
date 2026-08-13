<?php


// Protege a ação: só usuários logados podem cadastrar contatos.
require_once '../auth/protect.php';

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../repositories/contact_repository.php';

// Garante que este arquivo só processe envios do formulário.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

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

$cidadePertenceAoEstado = cityBelongsToState($pdo, $cidadeId, $estadoId);

if (!$cidadePertenceAoEstado) {
    die('A cidade selecionada não pertence ao estado selecionado.');
}

$data = [
    'nome' => $nome,
    'telefone' => $telefone,
    'email' => $email,
    'cpf' => $cpf,
    'cidadeId' => $cidadeId,
    'estadoId' => $estadoId,
];

// Prepara o cadastro do novo contato usando parâmetros para evitar SQL injection.
if (!createContact($pdo, $_SESSION['usuario_id'], $data)) {
    die('Erro ao cadastrar contato.');
}

// Após salvar, volta para a listagem.
redirect('index.php');
