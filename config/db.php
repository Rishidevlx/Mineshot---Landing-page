<?php
// config/db.php

if (!function_exists('loadEnv')) {
    function loadEnv($path = __DIR__ . '/../.env') {
        if (!file_exists($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                // Remove surrounding quotes if any
                $value = trim($value, "\"'");
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}

// Load .env automatically
loadEnv();

if (!function_exists('env')) {
    function env($key, $default = null) {
        $val = getenv($key);
        if ($val === false) {
            $val = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        }
        return $val;
    }
}

if (!function_exists('getDBConnection')) {
    function getDBConnection() {
        static $pdo = null;
        if ($pdo !== null) {
            return $pdo;
        }

        $host = env('DB_HOST');
        $port = env('DB_PORT', 4000);
        $user = env('DB_USER');
        $pass = env('DB_PASSWORD');
        $name = env('DB_NAME', 'mineshot_db');
        $sslCa = env('DB_SSL_CA');

        if (empty($host) || empty($user)) {
            return null; // Credentials not set yet
        }

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 5
            ];

            // Configure SSL for TiDB Cloud
            if (!empty($sslCa) && file_exists($sslCa)) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = $sslCa;
            } else {
                // Setting MYSQL_ATTR_SSL_CA to true/dummy forces TLS/SSL connection for TiDB Serverless
                $options[PDO::MYSQL_ATTR_SSL_CA] = true;
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }

            $pdo = new PDO($dsn, $user, $pass, $options);
            ensureDatabaseSchema($pdo);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('ensureDatabaseSchema')) {
    function ensureDatabaseSchema($pdo) {
        if (!$pdo) return;

        try {
            // 1. Admin users table
            $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(191) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 2. Projects & Gallery images table
            $pdo->exec("CREATE TABLE IF NOT EXISTS projects_gallery (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) DEFAULT '',
                category VARCHAR(100) NOT NULL DEFAULT 'photography',
                image_url TEXT NOT NULL,
                public_id VARCHAR(255) NOT NULL,
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 3. Seed default admin if table is empty
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM admin_users");
            $row = $stmt->fetch();
            if ($row && $row['count'] == 0) {
                $defaultEmail = env('DEFAULT_ADMIN_EMAIL', 'admin@mineshot.in');
                $defaultPassword = env('DEFAULT_ADMIN_PASSWORD', 'admin123');
                $hash = password_hash($defaultPassword, PASSWORD_DEFAULT);

                $insert = $pdo->prepare("INSERT INTO admin_users (email, password_hash) VALUES (?, ?)");
                $insert->execute([$defaultEmail, $hash]);
            }
        } catch (Exception $e) {
            error_log("Schema initialization error: " . $e->getMessage());
        }
    }
}
