<?php
require_once '../includes/header.php';
?>
    <h1>Login</h1>
    <form action="auth.php" method="post">
        
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha">
        </div>
        <button type="submit">Entrar</button>
    </form>

    <p>
        <a href="register.php">Cadastre-se</a>
    </p>
<?php require_once '../includes/footer.php'; ?>