<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {

            $config = require __DIR__ . '/../../config/database.php';

            if (!is_array($config)) {
                throw new \RuntimeException(
                    'File config/database.php harus melakukan return array.'
                );
            }

            $host    = $config['host'] ?? '127.0.0.1';
            $port    = $config['port'] ?? '3306';
            $dbname  = $config['dbname'] ?? '';
            $charset = $config['charset'] ?? 'utf8mb4';
            $user    = $config['user'] ?? 'root';
            $pass    = $config['pass'] ?? '';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            try {
                self::$instance = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {

                $logDirectory = __DIR__ . '/../../storage/logs';

                if (!is_dir($logDirectory)) {
                    mkdir($logDirectory, 0777, true);
                }

                error_log(
                    date('Y-m-d H:i:s') .
                    ' - ' .
                    $e->getMessage() .
                    PHP_EOL,
                    3,
                    $logDirectory . '/app.log'
                );

                die('Koneksi database gagal. Silakan hubungi administrator.');
            }
        }

        return self::$instance;
    }
}