<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware\AuthMiddleware;
use App\Repositories\ProdiRepository;

class ProdiController extends Controller
{
    private ProdiRepository $prodiRepo;

    public function __construct(?ProdiRepository $prodiRepo = null)
    {
        AuthMiddleware::check();
        $this->prodiRepo = $prodiRepo ?? new ProdiRepository(Database::getConnection());
    }

    public function index(): void
    {
        $this->view('prodi/index', [
            'prodi' => $this->prodiRepo->getAll(),
            'flash' => flash(),
        ]);
    }

    public function create(): void
    {
        $this->view('prodi/create', ['old' => []]);
    }

    public function store(): void
    {
        $nama = trim($_POST['nama'] ?? '');

        if ($nama === '') {
            $this->view('prodi/create', 
            ['error' => 'Nama prodi wajib diisi.', 'old' => ['nama' => $nama]]);
            return;
        }

        $this->prodiRepo->create($nama);
        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Prodi berhasil ditambahkan.'];
        $this->redirect('/prodi');
    }

    public function edit(string $id): void
    {
        $prodi = $this->prodiRepo->findById((int) $id);
        if (!$prodi) {
            $this->redirect('/prodi');
        }
        $this->view('prodi/edit', ['prodi' => $prodi]);
    }

    public function update(string $id): void
    {
        $nama = trim($_POST['nama'] ?? '');
        if ($nama === '') {
            $prodi = $this->prodiRepo->findById((int) $id);
            $this->view('prodi/edit', 
            ['error' => 'Nama prodi wajib diisi.', 'prodi' => $prodi]);
            return;
        }

        $this->prodiRepo->update((int) $id, $nama);
        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Prodi berhasil diperbarui.'];
        $this->redirect('/prodi');
    }

    public function delete(string $id): void
    {
        $this->prodiRepo->delete((int) $id);
        $_SESSION['flash'] = 
        ['type' => 'success', 'message' => 'Prodi berhasil dihapus.'];
        $this->redirect('/prodi');
    }
}
