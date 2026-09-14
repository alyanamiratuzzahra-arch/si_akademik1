<?php

namespace App\Repositories;

use App\Core\Model;
use PDO;

class MahasiswaRepository extends Model
{
    // =========================
    // READ ALL
    // =========================
    public function getAll(?string $search = null): array
    {
        $sql = "
            SELECT 
                mahasiswa.nim,
                mahasiswa.nama,
                mahasiswa.email,
                mahasiswa.prodi_id,
                prodi.nama AS prodi_nama,
                CONCAT('20', SUBSTRING(mahasiswa.nim, 1, 2)) AS angkatan
            FROM mahasiswa
            LEFT JOIN prodi ON mahasiswa.prodi_id = prodi.id
        ";

        $params = [];

        if ($search) {
            $sql .= "
                WHERE mahasiswa.nim LIKE :search
                   OR mahasiswa.nama LIKE :search
                   OR mahasiswa.email LIKE :search
            ";

            $params['search'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY mahasiswa.nim ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // =========================
    // FIND BY NIM
    // =========================
    public function findByNim(string $nim): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT 
                mahasiswa.nim,
                mahasiswa.nama,
                mahasiswa.email,
                mahasiswa.prodi_id,
                prodi.nama AS prodi_nama,
                CONCAT('20', SUBSTRING(mahasiswa.nim, 1, 2)) AS angkatan
             FROM mahasiswa
             LEFT JOIN prodi ON mahasiswa.prodi_id = prodi.id
             WHERE mahasiswa.nim = :nim"
        );

        $stmt->execute([
            'nim' => $nim
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }


    // =========================
    // CREATE
    // =========================
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO mahasiswa
            (nim, nama, email, prodi_id)
            VALUES
            (:nim, :nama, :email, :prodi_id)"
        );

        return $stmt->execute([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'prodi_id' => $data['prodi_id']
        ]);
    }


    // =========================
    // UPDATE
    // =========================
    public function update(string $nim, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE mahasiswa
             SET nama = :nama,
                 email = :email,
                 prodi_id = :prodi_id
             WHERE nim = :nim"
        );

        return $stmt->execute([
            'nim' => $nim,
            'nama' => $data['nama'],
            'email' => $data['email'],
            'prodi_id' => $data['prodi_id']
        ]);
    }


    // =========================
    // DELETE
    // =========================
    public function delete(string $nim): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM mahasiswa
             WHERE nim = :nim"
        );

        return $stmt->execute([
            'nim' => $nim
        ]);
    }


    // =========================
    // CEK NIM
    // =========================
    public function existsByNim(
        string $nim,
        ?string $exceptNim = null
    ): bool {

        if ($exceptNim !== null) {

            $stmt = $this->db->prepare(
                "SELECT nim
                 FROM mahasiswa
                 WHERE nim = :nim
                 AND nim != :except_nim"
            );

            $stmt->execute([
                'nim' => $nim,
                'except_nim' => $exceptNim
            ]);

        } else {

            $stmt = $this->db->prepare(
                "SELECT nim
                 FROM mahasiswa
                 WHERE nim = :nim"
            );

            $stmt->execute([
                'nim' => $nim
            ]);
        }

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}