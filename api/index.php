<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Create necessary /tmp storage directories (Vercel filesystem is read-only except /tmp)
$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Pre-populate bootstrap cache from project if available
if (!file_exists('/tmp/bootstrap/cache/packages.php') && file_exists(__DIR__ . '/../bootstrap/cache/packages.php')) {
    @copy(__DIR__ . '/../bootstrap/cache/packages.php', '/tmp/bootstrap/cache/packages.php');
}
if (!file_exists('/tmp/bootstrap/cache/services.php') && file_exists(__DIR__ . '/../bootstrap/cache/services.php')) {
    @copy(__DIR__ . '/../bootstrap/cache/services.php', '/tmp/bootstrap/cache/services.php');
}

// 3. Set paths for Laravel
putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// 4. Maintenance mode check
if (file_exists($maintenance = '/tmp/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 5. Register Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 6. Bootstrap Laravel and handle the request
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
