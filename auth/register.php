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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
</head>
<body>
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
</body>
</html>
