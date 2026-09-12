<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method'  => strtoupper($method),
            'path'    => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(?string $uri = null, ?string $method = null): void
    {
        $uri = $uri ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $method ?? $_SERVER['REQUEST_METHOD'];

        // Hapus base folder (misal /akademik1/public) dari URI secara otomatis,
        // supaya project ini tetap jalan di folder apa saja.
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        if ($baseDir !== '' && strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }

        // Normalisasi URI menjadi format standar seperti /login atau /mahasiswa
        $uri = '/' . trim($uri, '/');
        if ($uri === '/index.php' || $uri === '') {
            $uri = '/';
        }

        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    echo "Controller {$controllerClass} tidak ditemukan.";
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    echo "Method {$action} tidak ditemukan di {$controllerClass}.";
                    return;
                }

                call_user_func_array([$controller, $action], array_map('urldecode', $matches));
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>Halaman tidak ditemukan.</p>";
        echo "<small style='color:gray;'>Debug -> URI dibaca: <b>" . htmlspecialchars($uri) . "</b> | Method: <b>" . htmlspecialchars($method) . "</b></small>";
    }
}
