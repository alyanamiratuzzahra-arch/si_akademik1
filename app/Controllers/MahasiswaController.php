<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware\AuthMiddleware;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use App\Services\MahasiswaService;

class MahasiswaController extends Controller
{
    private MahasiswaRepository $mahasiswaRepo;
    private ProdiRepository $prodiRepo;
    private MahasiswaService $mahasiswaService;

    public function __construct(
        ?MahasiswaRepository $mahasiswaRepo = null,
        ?ProdiRepository $prodiRepo = null,
        ?MahasiswaService $mahasiswaService = null
    ) {
        AuthMiddleware::check();

       $db = Database::getConnection();

        $this->mahasiswaRepo = $mahasiswaRepo ?? new MahasiswaRepository($db);
        $this->prodiRepo = $prodiRepo ?? new ProdiRepository($db);
        $this->mahasiswaService = $mahasiswaService
            ?? new MahasiswaService(
                $this->mahasiswaRepo,
                $this->prodiRepo
            );
    }

    // =========================
    // READ
    // =========================
    public function index(): void
    {
        try {
            $search = trim($_GET['search'] ?? '');

            $mahasiswa = $this->mahasiswaRepo->getAll(
                $search ?: null
            );

            $this->view('mahasiswa/index', [
                'title' => 'Data Mahasiswa',
                'mahasiswa' => $mahasiswa,
                'search' => $search,
                'flash' => flash(),
            ]);

        } catch (\Exception $e) {

            $this->logError(
                'Gagal mengambil data mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Data mahasiswa gagal ditampilkan.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create(): void
    {
        try {
            $this->view('mahasiswa/create', [
                'title' => 'Tambah Mahasiswa',
                'prodi' => $this->prodiRepo->getAll(),
                'old' => [],
            ]);

        } catch (\Exception $e) {

            $this->logError(
                'Gagal membuka form mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Halaman tambah mahasiswa gagal dibuka.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // CREATE
    // =========================
    public function store(): void
    {
        $input = [
            'nim' => trim($_POST['nim'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];

        try {

            $result = $this->mahasiswaService->create($input);

            if ($result['success']) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Data mahasiswa berhasil ditambahkan.'
                ];

                // PRG
                $this->redirect('/mahasiswa');
                return;
            }

            $this->view('mahasiswa/create', [
                'title' => 'Tambah Mahasiswa',
                'error' => $result['message'],
                'prodi' => $this->prodiRepo->getAll(),
                'old' => $input,
            ]);

        } catch (\Exception $e) {

            $this->logError(
                'Gagal menambahkan mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Data mahasiswa gagal disimpan.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(string $nim): void
    {
        try {

            $mahasiswa = $this->mahasiswaRepo->findByNim($nim);

            if (!$mahasiswa) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Data mahasiswa tidak ditemukan.'
                ];

                $this->redirect('/mahasiswa');
                return;
            }

            $this->view('mahasiswa/edit', [
                'title' => 'Edit Mahasiswa',
                'mahasiswa' => $mahasiswa,
                'prodi' => $this->prodiRepo->getAll(),
            ]);

        } catch (\Exception $e) {

            $this->logError(
                'Gagal membuka data mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Data mahasiswa gagal ditampilkan.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // UPDATE
    // =========================
    public function update(string $nim): void
    {
        $input = [
            'nama' => trim($_POST['nama'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];

        try {

            $result = $this->mahasiswaService->update(
                $nim,
                $input
            );

            if ($result['success']) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Data mahasiswa berhasil diubah.'
                ];

                // PRG
                $this->redirect('/mahasiswa');
                return;
            }

            if (!empty($result['notFound'])) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => $result['message']
                ];

                $this->redirect('/mahasiswa');
                return;
            }

            $this->view('mahasiswa/edit', [
                'title' => 'Edit Mahasiswa',
                'error' => $result['message'],
                'mahasiswa' => $this->mahasiswaRepo->findByNim($nim),
                'prodi' => $this->prodiRepo->getAll(),
            ]);

        } catch (\Exception $e) {

            $this->logError(
                'Gagal mengubah data mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Data mahasiswa gagal diubah.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // DELETE
    // =========================
    public function delete(string $nim): void
    {
        try {

            $this->mahasiswaRepo->delete($nim);

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Data mahasiswa berhasil dihapus.'
            ];

            // PRG
            $this->redirect('/mahasiswa');

        } catch (\Exception $e) {

            $this->logError(
                'Gagal menghapus mahasiswa: '
                . $e->getMessage()
            );

            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Data mahasiswa gagal dihapus.'
            ];

            $this->redirect('/mahasiswa');
        }
    }

    // =========================
    // LOGGING
    // =========================
    private function logError(string $message): void
    {
        $logDirectory = dirname(__DIR__, 2) . '/storage/logs';

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0777, true);
        }

        $logFile = $logDirectory . '/app.log';

        $date = date('Y-m-d H:i:s');

        file_put_contents(
            $logFile,
            "[$date] $message" . PHP_EOL,
            FILE_APPEND
        );
    }
}