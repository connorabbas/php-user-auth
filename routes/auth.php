<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterController;

// Valid Routes for Site

$router->get('/register', [RegisterController::class, 'index']);
$router->post('/register', [RegisterController::class, 'store']);

$router->get('/login', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'doLogin']);

$router->post('/logout', [LogoutController::class, 'doLogout']);
