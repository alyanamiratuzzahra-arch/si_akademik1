<?php

namespace App\Repositories;

use App\Core\Model;
use PDO;

class ProdiRepository extends Model
{
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM prodi ORDER BY nama ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM prodi WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(string $nama): bool
    {
        $stmt = $this->db->prepare("INSERT INTO prodi (nama) VALUES (:nama)");
        return $stmt->execute(['nama' => $nama]);
    }

    public function update(int $id, string $nama): bool
    {
        $stmt = $this->db->prepare("UPDATE prodi SET nama = :nama WHERE id = :id");
        return $stmt->execute(['nama' => $nama, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM prodi WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}