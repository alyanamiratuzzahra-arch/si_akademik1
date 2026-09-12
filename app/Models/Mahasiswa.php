<?php

namespace App\Models;

use InvalidArgumentException;

class Mahasiswa
{
    private string $nim;
    private string $nama;
    private ?string $email;
    private int $prodiId;
    private int $angkatan;

    private ?string $prodiNama = null;

    public function __construct(
        string $nim,
        string $nama,
        ?string $email,
        int $prodiId
    ) {
        $this->setNim($nim);
        $this->setNama($nama);
        $this->setEmail($email);
        $this->setProdiId($prodiId);
    }

    // ================= Getter & Setter =================

    public function getNim(): string
    {
        return $this->nim;
    }

    public function setNim(string $nim): void
    {
        $nim = trim($nim);

        if ($nim === '') {
            throw new InvalidArgumentException('NIM tidak boleh kosong.');
        }

        if (!ctype_digit($nim)) {
            throw new InvalidArgumentException('NIM harus berupa angka.');
        }

        if (strlen($nim) < 2) {
            throw new InvalidArgumentException('NIM minimal 2 digit (untuk menentukan angkatan).');
        }

        $this->nim = $nim;

        $this->angkatan = (int) ('20' . substr($nim, 0, 2));
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);

        if ($nama === '') {
            throw new InvalidArgumentException('Nama mahasiswa tidak boleh kosong.');
        }

        $this->nama = $nama;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $email = $email !== null ? trim($email) : null;

        if ($email !== null && $email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Format email tidak valid.');
        }

        $this->email = ($email === '') ? null : $email;
    }

    public function getProdiId(): int
    {
        return $this->prodiId;
    }

    public function setProdiId(int $prodiId): void
    {
        if ($prodiId <= 0) {
            throw new InvalidArgumentException('Program studi wajib dipilih.');
        }

        $this->prodiId = $prodiId;
    }

    public function getAngkatan(): int
    {
        return $this->angkatan;
    }

    public function getProdiNama(): ?string
    {
        return $this->prodiNama;
    }

    public function setProdiNama(?string $prodiNama): void
    {
        $this->prodiNama = $prodiNama;
    }
}
