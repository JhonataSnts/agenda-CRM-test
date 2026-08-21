<?php

require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';

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
$categorias = $pdo->query('SELECT id, nome FROM categorias ORDER BY nome ASC')->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Editar Contato';

require_once '../includes/header.php';
?>
    <h1>Editar Contato</h1>

    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $contato['id'] ?>">

        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= e($contato['nome']) ?>" required>
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= e($contato['telefone']) ?>" required>
        </div>

        <div></div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($contato['email'] ?? '') ?>" required>
        </div>

        <div>
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" value="<?= e($contato['cpf'] ?? '') ?>" required>
        </div>

        <div>
            <label for="estado_id">Estado</label>
            <select id="estado_id" name="estado_id" required>
                <option value="">Selecione um estado</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado['id'] ?>" <?= $estado['id'] == $contato['estado_id'] ? 'selected' : '' ?>>
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
                    <option value="<?= $cidade['id'] ?>" <?= $cidade['id'] == $contato['cidade_id'] ? 'selected' : '' ?>>
                        <?= e($cidade['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="categoria_id">Categoria</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>">
                        <?= e($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Atualizar</button>
        <a href="index.php">Voltar</a>
    </form>
<?php require_once '../includes/footer.php'; ?>
