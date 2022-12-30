<?php

use App\Controllers\UserController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterController;

/**
 * Valid Routes for Site
 */

$this->router->view('/', 'pages.welcome');

$this->router->get('/register', [RegisterController::class, 'index']);
$this->router->post('/register', [RegisterController::class, 'store']);

$this->router->get('/login', [LoginController::class, 'index']);
$this->router->post('/login', [LoginController::class, 'doLogin']);
$this->router->post('/logout', [LogoutController::class, 'doLogout']);

$this->router->get('/account', [UserController::class, 'index']);
$this->router->patch('/account', [UserController::class, 'update']);
$this->router->delete('/account', [UserController::class, 'destroy']);
