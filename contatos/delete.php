<?php

session_start();

if (!isset($_SESSION['contato_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

$stmt = $pdo->prepare('DELETE FROM contatos WHERE id = :id');
$stmt->execute([':id' => $id]);

header('Location: index.php');
exit;
