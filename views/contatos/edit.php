<?php

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

        <div>
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
                    <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $contato['categoria_id'] ? 'selected' : '' ?>>
                        <?= e($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Atualizar</button>
        <a href="index.php">Voltar</a>
    </form>
<?php require_once '../includes/footer.php'; ?>