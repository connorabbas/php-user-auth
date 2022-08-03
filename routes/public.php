<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;

// Valid Routes for Site

$router->view('/', 'pages/welcome');

$router->get('/login', [LoginController::class, 'index']);
$router->get('/register', [RegisterController::class, 'index']);