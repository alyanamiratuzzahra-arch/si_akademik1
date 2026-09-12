<?php

namespace App\Repositories;

use App\Core\Model;
use App\Models\Mahasiswa;

class MahasiswaRepository extends Model
{
    /**
     * @return Mahasiswa[]
     */
    public function getAll(?string $keyword = null): array
    {
        if ($keyword) {
            $stmt = $this->db->prepare("
                SELECT m.*, p.nama AS prodi_nama 
                FROM mahasiswa m 
                JOIN prodi p ON m.prodi_id = p.id 
                WHERE m.nim LIKE :keyword1 OR m.nama LIKE :keyword2
                ORDER BY m.nim ASC
            ");
            $stmt->execute([
                'keyword1' => '%' . $keyword . '%',
                'keyword2' => '%' . $keyword . '%',
            ]);
        } else {
            $stmt = $this->db->prepare("
                SELECT m.*, p.nama AS prodi_nama 
                FROM mahasiswa m 
                JOIN prodi p ON m.prodi_id = p.id 
                ORDER BY m.nim ASC
            ");
            $stmt->execute();
        }

        return array_map([$this, 'mapToModel'], $stmt->fetchAll());
    }

    public function findByNim(string $nim): ?Mahasiswa
    {
        $stmt = $this->db->prepare("
            SELECT m.*, p.nama AS prodi_nama 
            FROM mahasiswa m 
            JOIN prodi p ON m.prodi_id = p.id 
            WHERE m.nim = :nim
        ");
        $stmt->execute(['nim' => $nim]);
        $row = $stmt->fetch();

        return $row ? $this->mapToModel($row) : null;
    }

    public function create(Mahasiswa $mahasiswa): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan) 
            VALUES (:nim, :nama, :email, :prodi_id, :angkatan)
        ");

        return $stmt->execute([
            'nim' => $mahasiswa->getNim(),
            'nama' => $mahasiswa->getNama(),
            'email' => $mahasiswa->getEmail(),
            'prodi_id' => $mahasiswa->getProdiId(),
            'angkatan' => $mahasiswa->getAngkatan(),
        ]);
    }

    public function update(string $nim, Mahasiswa $mahasiswa): bool
    {
        $stmt = $this->db->prepare("
            UPDATE mahasiswa 
            SET nama = :nama, email = :email, 
            prodi_id = :prodi_id, angkatan = :angkatan 
            WHERE nim = :nim
        ");

        return $stmt->execute([
            'nama' => $mahasiswa->getNama(),
            'email' => $mahasiswa->getEmail(),
            'prodi_id' => $mahasiswa->getProdiId(),
            'angkatan' => $mahasiswa->getAngkatan(),
            'nim' => $nim,
        ]);
    }

    public function delete(string $nim): bool
    {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE nim = :nim");
        return $stmt->execute(['nim' => $nim]);
    }

    /**
     * Ubah 1 baris hasil query (array) menjadi object Mahasiswa.
     */
    private function mapToModel(array $row): Mahasiswa
    {
        $mahasiswa = new Mahasiswa(
            $row['nim'],
            $row['nama'],
            $row['email'],
            (int) $row['prodi_id']
        );
        $mahasiswa->setProdiNama($row['prodi_nama'] ?? null);

        return $mahasiswa;
    }
}