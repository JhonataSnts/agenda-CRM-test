<?php

function listContactsByUser($pdo, $userId, $filters) {
    $sql = "
        SELECT
            contatos.id,
            contatos.nome,
            contatos.telefone,
            contatos.email,
            contatos.cpf,
            cidades.nome AS cidade_nome,
            estados.nome AS estado_nome
        FROM contatos
        INNER JOIN cidades ON cidades.id = contatos.cidade_id
        INNER JOIN estados ON estados.id = contatos.estado_id
        WHERE contatos.usuario_id = :usuario_id
            AND contatos.nome LIKE :nome
            AND contatos.telefone LIKE :telefone
            AND (:email = '' OR contatos.email LIKE :email_like)
            AND (:cpf = '' OR contatos.cpf LIKE :cpf_like)
            AND cidades.nome LIKE :cidade
            AND estados.nome LIKE :estado
        ORDER BY contatos.nome ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'usuario_id' => $userId,
        ':nome' => "%{$filters['nome']}%",
        ':telefone' => "%{$filters['telefone']}%",
        ':email' => $filters['email'],
        ':email_like' => "%{$filters['email']}%",
        ':cpf' => $filters['cpf'],
        ':cpf_like' => "%{$filters['cpf']}%",
        ':cidade' => "%{$filters['cidade']}%",
        ':estado' => "%{$filters['estado']}%",
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cityBelongsToState($pdo, $cidadeId, $estadoId) {
    $sql = "SELECT COUNT(*) FROM cidades WHERE id = :cidade_id AND estado_id = :estado_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cidade_id' => $cidadeId,
        ':estado_id' => $estadoId
    ]);
    return $stmt->fetchColumn() > 0;
}

function createContact($pdo, $usuarioId, $data) {
    $sql = '
    INSERT INTO contatos (nome, telefone, email, cpf, cidade_id, estado_id, usuario_id)
    VALUES (:nome, :telefone, :email, :cpf, :cidade_id, :estado_id, :usuario_id)
';

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nome' => $data['nome'],
        ':telefone' => $data['telefone'],
        ':email' => $data['email'],
        ':cpf' => $data['cpf'],
        ':cidade_id' => $data['cidadeId'],
        ':estado_id' => $data['estadoId'],
        ':usuario_id' => $usuarioId
    ]);
    
}

function updateContactByUser($pdo, $usuarioId, $id, $data) {
    $sql = '
    UPDATE contatos
    SET nome = :nome,
        telefone = :telefone,
        email = :email,
        cpf = :cpf,
        cidade_id = :cidade_id,
        estado_id = :estado_id
    WHERE id = :id AND usuario_id = :usuario_id
';

$stmt = $pdo->prepare($sql);
return $stmt->execute([
    ':nome' => $data['nome'],
    ':telefone' => $data['telefone'],
    ':email' => $data['email'],
    ':cpf' => $data['cpf'],
    ':cidade_id' => $data['cidadeId'],
    ':estado_id' => $data['estadoId'],
    ':id' => $id,
    ':usuario_id' => $usuarioId
]);
}

function deleteContactByUser($pdo, $usuarioId, $id) {
    $stmt = $pdo->prepare('DELETE FROM contatos WHERE id = :id AND usuario_id = :usuario_id');
    return $stmt->execute([
    ':id' => $id,
    ':usuario_id' => $usuarioId
]);
}
