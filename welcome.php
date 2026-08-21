<?php
require_once 'helpers/functions.php';

$pageTitle = 'Agenda de Contatos';
$assetPath = 'assets/css/style.css';
$bodyClass = 'welcome-page';

require_once 'includes/header.php';
?>
    <main class="welcome">
        <h1>Agenda de Contatos</h1>
        <p>Organize seus contatos por usuario, cidade, estado e categoria em uma agenda simples feita em PHP.</p>

        <div class="welcome-actions">
            <a class="button" href="auth/login.php">Entrar</a>
            <a class="button secondary" href="auth/register.php">Criar conta</a>
        </div>
    </main>
<?php require_once 'includes/footer.php'; ?>
