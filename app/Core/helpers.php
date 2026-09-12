<?php

/**
 * Menghasilkan URL yang benar secara otomatis, tidak peduli folder project
 * ditaruh di mana (htdocs/akademik1, htdocs/akademik1/public sebagai root, dll).
 * Ini menghilangkan bug "kadang 404" akibat path yang di-hardcode.
 */
if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        static $base = null;

        if ($base === null) {
            $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
            $base = rtrim(str_replace('\\', '/', dirname($script)), '/');
        }

        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . base_url($path));
        exit;
    }
}

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('flash')) {
    /**
     * Ambil dan hapus flash message dari session (tampil sekali lalu hilang).
     */
    function flash(): ?array
    {
        if (!empty($_SESSION['flash'])) {
            $data = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $data;
        }
        return null;
    }
}
