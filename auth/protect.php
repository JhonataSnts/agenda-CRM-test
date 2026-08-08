<?php

session_start();

if (!isset($_SESSION['contato_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

