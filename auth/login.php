<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../contatos/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Agenda de Contatos</title>
</head>
<body>
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
</body>
</html>
