<?php



require_once '../auth/protect.php';

require_once '../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    die('Contato inválido.');
}

$stmt = $pdo->prepare('SELECT id, nome, telefone, cidade_id, estado_id FROM contatos WHERE id = :id AND usuario_id = :usuario_id');
$stmt->execute([
    ':id' => $id,
    ':usuario_id' => $_SESSION['usuario_id']
]);
$contato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contato) {
    die('Contato não encontrado.');
}

$estados = $pdo->query('SELECT id, nome, uf FROM estados ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
$cidades = $pdo->query('SELECT id, nome, estado_id FROM cidades ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
</head>
<body>
    <h1>Editar Contato</h1>

    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $contato['id'] ?>">

        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($contato['nome']) ?>" required>
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($contato['telefone']) ?>" required>
        </div>

        <div>
            <label for="estado_id">Estado</label>
            <select id="estado_id" name="estado_id" required>
                <option value="">Selecione um estado</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado['id'] ?>" <?= $estado['id'] == $contato['estado_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($estado['nome']) ?> (<?= htmlspecialchars($estado['uf']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="cidade_id">Cidade</label>
            <select id="cidade_id" name="cidade_id" required>
                <option value="">Selecione uma cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= $cidade['id'] ?>" <?= $cidade['id'] == $contato['cidade_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cidade['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Atualizar</button>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>
