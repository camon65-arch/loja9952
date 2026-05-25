<?php
namespace App;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        self::loadEnv();

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $name = $_ENV['DB_NAME'] ?? '';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';

        if ($name === '') {
            throw new PDOException('DB_NAME nao esta definido no ficheiro .env.');
        }

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

        self::$connection = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }

    private static function loadEnv(): void {
        $envFile = dirname(__DIR__).'/.env';

        if (!is_file($envFile)) {
            return;
        }

        $env = parse_ini_file($envFile, false, INI_SCANNER_RAW);
        if ($env === false) {
            return;
        }

        foreach ($env as $key => $value) {
            $_ENV[$key] = $value;
        }
    }
}
