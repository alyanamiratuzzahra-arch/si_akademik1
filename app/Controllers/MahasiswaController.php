<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware\AuthMiddleware;
use App\Models\Mahasiswa;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use InvalidArgumentException;
use PDOException;

class MahasiswaController extends Controller
{
    private MahasiswaRepository $mahasiswaRepo;
    private ProdiRepository $prodiRepo;

    public function __construct(
        ?MahasiswaRepository $mahasiswaRepo = null,
        ?ProdiRepository $prodiRepo = null
    ) {
        AuthMiddleware::check();

        $db = Database::getInstance();
        $this->mahasiswaRepo = $mahasiswaRepo ?? new MahasiswaRepository($db);
        $this->prodiRepo = $prodiRepo ?? new ProdiRepository($db);
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $mahasiswa = $this->mahasiswaRepo->getAll($search ?: null);

        $this->view('mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'search' => $search,
            'flash' => flash(),
        ]);
    }

    public function create(): void
    {
        $this->view('mahasiswa/create', [
            'title' => 'Tambah Mahasiswa',
            'prodi' => $this->prodiRepo->getAll(),
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $old = [
            'nim' => trim($_POST['nim'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];

        try {
            if ($this->mahasiswaRepo->findByNim($old['nim'])) {
                throw new InvalidArgumentException('NIM sudah terdaftar, gunakan NIM lain.');
            }

            // Object Mahasiswa memvalidasi datanya sendiri lewat setter
            // (composition: Controller "memiliki" Model, bukan mewarisinya).
            $mahasiswa = new Mahasiswa(
                $old['nim'],
                $old['nama'],
                $old['email'] ?: null,
                $old['prodi_id']
            );

            $this->mahasiswaRepo->create($mahasiswa);

            $_SESSION['flash'] = 
            ['type' => 'success', 'message' => 'Data mahasiswa berhasil ditambahkan.'];
            $this->redirect('/mahasiswa');
            } catch (InvalidArgumentException|PDOException $e) {
                $this->view('mahasiswa/create', [
                    'title' => 'Tambah Mahasiswa',
                    'error' => $e->getMessage(),
                    'prodi' => $this->prodiRepo->getAll(),
                    'old' => $old,
            ]);
        }
    }

    public function edit(string $nim): void
    {
        $mahasiswa = $this->mahasiswaRepo->findByNim($nim);

        if (!$mahasiswa) {
            $_SESSION['flash'] = 
            ['type' => 'danger', 'message' => 'Data mahasiswa tidak ditemukan.'];
            $this->redirect('/mahasiswa');
        }

        $this->view('mahasiswa/edit', [
            'title' => 'Edit Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'prodi' => $this->prodiRepo->getAll(),
        ]);
    }

    public function update(string $nim): void
    {
        $existing = $this->mahasiswaRepo->findByNim($nim);

        if (!$existing) {
            $_SESSION['flash'] = 
            ['type' => 'danger', 'message' => 'Data mahasiswa tidak ditemukan.'];
            $this->redirect('/mahasiswa');
        }

        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $prodiId = (int) ($_POST['prodi_id'] ?? 0);

        try {
            $mahasiswa = new Mahasiswa($nim, $nama, $email ?: null, $prodiId);
            $this->mahasiswaRepo->update($nim, $mahasiswa);

            $_SESSION['flash'] = 
            ['type' => 'success', 'message' => 'Data mahasiswa berhasil diperbarui.'];
            $this->redirect('/mahasiswa');
        } catch (InvalidArgumentException|PDOException $e) {
            $this->view('mahasiswa/edit', [
                'title' => 'Edit Mahasiswa',
                'error' => $e->getMessage(),
                'mahasiswa' => $existing,
                'prodi' => $this->prodiRepo->getAll(),
            ]);
        }
    }

    public function delete(string $nim): void
    {
        $this->mahasiswaRepo->delete($nim);
        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Data mahasiswa berhasil dihapus.'];
        $this->redirect('/mahasiswa');
    }
}
