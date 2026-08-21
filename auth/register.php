<?php
require_once '../helpers/functions.php';
session_start();

if (isset($_SESSION['usuario_id'])) {
    redirect('../contatos/index.php');
    exit();
}

$pageTitle = 'Cadastre-se - Agenda de Contatos';

require_once '../includes/header.php';
?>
    <h1>Cadastre-se</h1>
    
    <form action="store_user.php" method="post">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit">Criar conta</button>
    </form>

    <p>
        <a href="login.php">Login</a>
    </p>
<?php require_once '../includes/footer.php'; ?>
