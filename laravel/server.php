<?php
/**
 * Laravel-compatible router script for PHP built-in server.
 * Returns false for existing static files so the built-in server serves them directly,
 * otherwise routes the request through public/index.php.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static file if it exists under public/
$publicPath = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($publicPath) && !is_dir($publicPath)) {
    return false;
}

// Otherwise, hand off to Laravel front-controller
require_once __DIR__ . '/public/index.php';
