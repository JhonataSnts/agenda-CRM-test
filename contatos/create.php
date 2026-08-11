<?php


require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';

$estados = $pdo->query('SELECT id, nome, uf FROM estados ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
$cidades = $pdo->query('SELECT id, nome, estado_id FROM cidades ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Contato</title>
</head>
<body>
    <h1>Novo Contato</h1>

    <form method="POST" action="store.php">
        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>

        <div>
            <label for="estado_id">Estado</label>
            <select id="estado_id" name="estado_id" required>
                <option value="">Selecione um estado</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado['id'] ?>">
                        <?= e($estado['nome']) ?> (<?= e($estado['uf']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="cidade_id">Cidade</label>
            <select id="cidade_id" name="cidade_id" required>
                <option value="">Selecione uma cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= $cidade['id'] ?>">
                        <?= e($cidade['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Salvar</button>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>
