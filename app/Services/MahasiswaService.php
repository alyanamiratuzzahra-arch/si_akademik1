<?php

namespace App\Services;

use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use Exception;

class MahasiswaService
{
    private MahasiswaRepository $mahasiswaRepo;
    private ProdiRepository $prodiRepo;

    public function __construct(
        MahasiswaRepository $mahasiswaRepo,
        ProdiRepository $prodiRepo
    ) {
        $this->mahasiswaRepo = $mahasiswaRepo;
        $this->prodiRepo = $prodiRepo;
    }

    /**
     * Menambahkan mahasiswa baru
     */
    public function create(array $data): array
    {
        try {
            // Validasi khusus tambah
            $this->validateCreate($data);

            // Cek NIM sudah terdaftar atau belum
            if ($this->mahasiswaRepo->existsByNim($data['nim'])) {
                throw new Exception('NIM sudah terdaftar.');
            }

            // Cek program studi
            if (!$this->prodiRepo->findById($data['prodi_id'])) {
                throw new Exception('Program studi tidak ditemukan.');
            }

            // Simpan data
            $this->mahasiswaRepo->create($data);

            return [
                'success' => true,
                'message' => 'Data mahasiswa berhasil ditambahkan.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Mengubah data mahasiswa
     */
    public function update(string $nim, array $data): array
    {
        try {
            // Validasi khusus edit
            $this->validateUpdate($data);

            // Cari mahasiswa berdasarkan NIM dari URL
            $mahasiswa = $this->mahasiswaRepo->findByNim($nim);

            if (!$mahasiswa) {
                return [
                    'success' => false,
                    'notFound' => true,
                    'message' => 'Data mahasiswa tidak ditemukan.'
                ];
            }

            // Cek program studi
            if (!$this->prodiRepo->findById($data['prodi_id'])) {
                throw new Exception('Program studi tidak ditemukan.');
            }

            // Update data
            $this->mahasiswaRepo->update($nim, $data);

            return [
                'success' => true,
                'message' => 'Data mahasiswa berhasil diubah.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Validasi saat tambah mahasiswa
     */
    private function validateCreate(array $data): void
    {
        if (empty(trim($data['nim'] ?? ''))) {
            throw new Exception('NIM wajib diisi.');
        }

        $this->validateCommon($data);
    }

    /**
     * Validasi saat edit mahasiswa
     */
    private function validateUpdate(array $data): void
    {
        $this->validateCommon($data);
    }

    /**
     * Validasi yang digunakan tambah dan edit
     */
    private function validateCommon(array $data): void
    {
        if (empty(trim($data['nama'] ?? ''))) {
            throw new Exception('Nama wajib diisi.');
        }

        if (empty(trim($data['email'] ?? ''))) {
            throw new Exception('Email wajib diisi.');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid.');
        }

        if (empty($data['prodi_id'] ?? 0)) {
            throw new Exception('Program studi wajib dipilih.');
        }
    }
}   