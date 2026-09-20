<?php
// api/index.php - Vercel Serverless Entry Point & Router
ini_set('display_errors', '0');
error_reporting(E_ALL);

$rootDir = realpath(__DIR__ . '/..') ?: (__DIR__ . '/..');
chdir($rootDir);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = rawurldecode($uri);
$path = trim($uri, '/');

// Handle static assets fallback
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|webp|svg|ico|woff|woff2|ttf|eot)$/i', $path)) {
    $assetPath = $rootDir . '/' . $path;
    if (file_exists($assetPath) && is_file($assetPath)) {
        $ext = strtolower(pathinfo($assetPath, PATHINFO_EXTENSION));
        $mimes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
        header('Cache-Control: public, max-age=31536000');
        readfile($assetPath);
        exit;
    }
}

// 1. Home route
if (empty($path) || $path === 'index.php') {
    require $rootDir . '/index.php';
    exit;
}

// 2. Admin routes
if ($path === 'admin' || $path === 'admin/' || $path === 'admin/index.php') {
    require $rootDir . '/admin/index.php';
    exit;
}

if ($path === 'admin/login' || $path === 'admin/login.php') {
    require $rootDir . '/admin/login.php';
    exit;
}

if ($path === 'admin/logout' || $path === 'admin/logout.php') {
    require $rootDir . '/admin/logout.php';
    exit;
}

if ($path === 'admin/api' || $path === 'admin/api.php') {
    require $rootDir . '/admin/api.php';
    exit;
}

// 3. Projects route
if ($path === 'projects' || $path === 'projects.php') {
    require $rootDir . '/projects.php';
    exit;
}

// 4. Any direct PHP file match
if (file_exists($rootDir . '/' . $path) && is_file($rootDir . '/' . $path)) {
    require $rootDir . '/' . $path;
    exit;
}

if (file_exists($rootDir . '/' . $path . '.php')) {
    require $rootDir . '/' . $path . '.php';
    exit;
}

// Fallback to index.php
require $rootDir . '/index.php';
