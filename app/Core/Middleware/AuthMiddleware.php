<?php

namespace App\Core\Middleware;

class AuthMiddleware
{
    /**
     * Pastikan user sudah login. Jika belum, lempar ke halaman login.
     */
    public static function check(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user'])) {
            redirect('/login');
        }
    }
}
