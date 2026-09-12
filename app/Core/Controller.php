<?php

namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        // Jika halaman login, jangan tampilkan navbar dan footer
        if (strpos($view, 'auth/') === 0) {
            if (file_exists(__DIR__ . '/../Views/' . $view . '.php')) {
                require_once __DIR__ . '/../Views/' . $view . '.php';
            }
            return;
        }

        // Untuk halaman lain (mahasiswa, dll), tampilkan partials lengkap
        if (file_exists(__DIR__ . '/../Views/partials/header.php')) {
            require_once __DIR__ . '/../Views/partials/header.php';
        }
        
        if (file_exists(__DIR__ . '/../Views/partials/navbar.php')) {
            require_once __DIR__ . '/../Views/partials/navbar.php';
        }

        if (file_exists(__DIR__ . '/../Views/' . $view . '.php')) {
            require_once __DIR__ . '/../Views/' . $view . '.php';
        }

        if (file_exists(__DIR__ . '/../Views/partials/footer.php')) {
            require_once __DIR__ . '/../Views/partials/footer.php';
        }
    }

        protected function redirect(string $url): void
        {
            header('Location: ' . base_url($url));
            exit;
        }
}