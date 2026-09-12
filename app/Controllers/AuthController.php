<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function index(): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect('/mahasiswa');
        }

        $this->view('auth/login', [
            'flash' => flash(),
        ]);
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (
            ($username === 'admin' && $password === 'admin123') ||
            ($username === 'admin@gmail.com' && $password === '123456')
        ) {
            $_SESSION['user'] = $username;
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Selamat datang, Admin',
            ];
            $this->redirect('/mahasiswa');
        }

        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Username atau password salah!',
        ];
        $this->redirect('/login');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Anda telah logout',
        ];

        $this->redirect('/login');
    }
}
