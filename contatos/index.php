<?php

require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../repositories/contact_repository.php';

$filters = [
    'nome' => $_GET['nome'] ?? '',
    'telefone' => $_GET['telefone'] ?? '',
    'email' => $_GET['email'] ?? '',
    'cpf' => $_GET['cpf'] ?? '',
    'cidade' => $_GET['cidade'] ?? '',
    'estado' => $_GET['estado'] ?? ''
];

$contatos = listContactsByUser($pdo, $_SESSION['usuario_id'], $filters);
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
        <a href="../auth/logout.php">Sair</a>
    </p>

    <br>

    <form method="GET" action="index.php">
        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= e($filters['nome']) ?>">
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= e($filters['telefone']) ?>">
        </div>

        <div>
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?= e($filters['cidade']) ?>">
        </div>

        <div>
            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado" value="<?= e($filters['estado']) ?>">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= e($filters['email']) ?>">
        </div>
        <div>
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" value="<?= e($filters['cpf']) ?>">
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
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contatos as $contato): ?>
                    <tr>
                        <td><?= e($contato['nome']) ?></td>
                        <td><?= e($contato['telefone']) ?></td>
                        <td><?= e($contato['email'] ?? '-') ?></td>
                        <td><?= e($contato['cpf'] ?? '-') ?></td>
                        <td><?= e($contato['cidade_nome']) ?></td>
                        <td><?= e($contato['estado_nome']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $contato['id'] ?>">Editar</a>
                            <form method="POST" action="delete.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este contato?');">
                                <input type="hidden" name="id" value="<?= $contato['id'] ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>

