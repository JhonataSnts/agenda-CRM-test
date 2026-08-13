<?php

function findUserByEmail($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function emailExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetchColumn() > 0;
}

function createUser($pdo, $nome, $email, $senhaHash) {
    $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $senhaHash]);
}