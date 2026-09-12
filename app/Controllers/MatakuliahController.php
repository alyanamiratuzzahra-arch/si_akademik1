<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware\AuthMiddleware;
use PDO;

class MatakuliahController extends Controller
{
    private PDO $db;

    public function __construct()
    {
        AuthMiddleware::check();
        $this->db = Database::getInstance();
    }

    public function index(): void
    {
        $stmt = $this->db->query("SELECT * FROM matakuliah ORDER BY id DESC");
        $data = $stmt->fetchAll();

        $this->view('matakuliah/index', ['matakuliah' => $data, 'flash' => flash()]);
    }

    public function create(): void
    {
        $this->view('matakuliah/create', ['old' => []]);
    }

    public function store(): void
    {
        $kode = trim($_POST['kode'] ?? '');
        $nama = trim($_POST['nama_mk'] ?? '');
        $sks = (int) ($_POST['sks'] ?? 0);

        if ($kode === '' || $nama === '') {
            $this->view('matakuliah/create', [
                'error' => 'Kode dan Nama Mata Kuliah wajib diisi.',
                'old' => ['kode' => $kode, 'nama_mk' => $nama, 'sks' => $sks],
            ]);
            return;
        }

        $stmt = $this->db->prepare
        ("INSERT INTO matakuliah (kode, nama_mk, sks) VALUES (:kode, :nama, :sks)");
        $stmt->execute(['kode' => $kode, 'nama' => $nama, 'sks' => $sks]);

        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Mata kuliah berhasil ditambahkan.'];
        $this->redirect('/matakuliah');
    }

    public function edit(string $id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM matakuliah WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $mk = $stmt->fetch();

        if (!$mk) {
            $this->redirect('/matakuliah');
        }

        $this->view('matakuliah/edit', ['mk' => $mk]);
    }

    public function update(string $id): void
    {
        $kode = trim($_POST['kode'] ?? '');
        $nama = trim($_POST['nama_mk'] ?? '');
        $sks = (int) ($_POST['sks'] ?? 0);

        if ($kode !== '' && $nama !== '') {
            $stmt = $this->db->prepare
            ("UPDATE matakuliah SET kode = :kode, nama_mk = :nama, sks = :sks WHERE id = :id");
            $stmt->execute(
                ['kode' => $kode, 'nama' => $nama, 'sks' => $sks, 'id' => $id]);
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mata kuliah berhasil diperbarui.'];
        $this->redirect('/matakuliah');
    }

    public function delete(string $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM matakuliah WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Mata kuliah berhasil dihapus.'];
        $this->redirect('/matakuliah');
    }
}
