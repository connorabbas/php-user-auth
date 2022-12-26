<?php

use App\Core\App;
use Dotenv\Dotenv;
use App\Core\Router;
use App\Core\Container;
use Dotenv\Exception\InvalidPathException;

/**
 * PHP Basic Framework
 * Developed and maintained by: Connor Abbas 
 * Docs: https://github.com/connorabbas/basic-framework#php-basic-framework
 */

// Composer autoload
if (file_exists('../vendor/autoload.php')) {
    require '../vendor/autoload.php';
}

// Register .env data into $_ENV super global
try {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
} catch (InvalidPathException) {
    echo '.env file not configured for site.';
    die;
}

// Global constants
require_once('../app/data/constants.php');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting
if (config('site.environment') == 'local') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Invoke the site
$container = new Container();
$router = new Router($container);
(new App($router))->run();