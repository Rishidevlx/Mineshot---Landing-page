<?php
// api/index.php - Vercel Serverless Entry Point & Router

// Set root working directory so all relative includes (header.php, footer.php, etc.) work correctly
chdir(__DIR__ . '/..');

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = rawurldecode($uri);
$path = trim($uri, '/');

// If empty, serve home page
if (empty($path)) {
    require __DIR__ . '/../index.php';
    exit;
}

// Check direct file match
$targetFile = __DIR__ . '/../' . $path;

// 1. Direct PHP file (e.g. projects.php, admin/login.php, admin/api.php)
if (is_file($targetFile) && pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
    require $targetFile;
    exit;
}

// 2. Directory with index.php (e.g. admin or admin/)
if (is_dir($targetFile) && is_file($targetFile . '/index.php')) {
    require $targetFile . '/index.php';
    exit;
}

// 3. Extensionless PHP route (e.g. /projects -> projects.php, /admin -> admin/index.php)
if (is_file($targetFile . '.php')) {
    require $targetFile . '.php';
    exit;
}

if ($path === 'admin') {
    require __DIR__ . '/../admin/index.php';
    exit;
}

// 4. Fallback: If not found or main route, serve index.php
if (file_exists(__DIR__ . '/../' . $path)) {
    $mime = mime_content_type($targetFile) ?: 'application/octet-stream';
    header("Content-Type: $mime");
    readfile($targetFile);
    exit;
}

require __DIR__ . '/../index.php';
