<?php

namespace App\Repositories;

class contact_repository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listByUser($userId, $filters) {

    }

    public function cityBelongsToState($cidadeId, $estadoId) {

    }

    public function create($usuarioId, $data) {

    }

    public function updateByUser($usuarioId, $id, $data) {

    }

    public function deleteByUser($usuarioId, $id) {
        
    }
}
