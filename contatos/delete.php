<?php



require_once '../auth/protect.php';

require_once '../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

$stmt = $pdo->prepare('DELETE FROM contatos WHERE id = :id AND usuario_id = :usuario_id');
$stmt->execute([
    ':id' => $id,
    ':usuario_id' => $_SESSION['usuario_id']
]);

header('Location: index.php');
exit;
