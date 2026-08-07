<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['contato_id'])) {
    header("Location: login.php");
    exit();
}

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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos</title>
</head>
<body>
    <h1>Agenda de Contatos</h1>

    <p>
        <a href="create.php">Novo contato</a>
    </p>

    <br>

    <form method="GET" action="index.php">
        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>">
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($telefone) ?>">
        </div>

        <div>
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($cidade) ?>">
        </div>

        <div>
            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($estado) ?>">
        </div>

        <button type="submit">Pesquisar</button>
        <a href="index.php">Limpar</a>
    </form>

    <br>

    <?php if (empty($contatos)): ?>
        <p>Nenhum contato encontrado.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contatos as $contato): ?>
                    <tr>
                        <td><?= htmlspecialchars($contato['nome']) ?></td>
                        <td><?= htmlspecialchars($contato['telefone']) ?></td>
                        <td><?= htmlspecialchars($contato['cidade_nome']) ?></td>
                        <td><?= htmlspecialchars($contato['estado_nome']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $contato['id'] ?>">Editar</a>
                            <a href="delete.php?id=<?= $contato['id'] ?>" onclick="return confirm('Deseja excluir este contato?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>

