<?php

namespace App\Core\Middleware;

class AuthMiddleware
{
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
