<?php

use App\Controllers\UserController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterController;

/**
 * Registered routes for your site
 */

$this->router->view('/', 'pages.welcome');

$this->router
    ->get('/register', [RegisterController::class, 'index'])
    ->post('/register', [RegisterController::class, 'store']);

$this->router
    ->get('/login', [LoginController::class, 'index'])
    ->post('/login', [LoginController::class, 'doLogin']);

$this->router->post('/logout', [LogoutController::class, 'doLogout']);

$this->router
    ->controller(UserController::class)
    ->batch(
        function () {
            $this->router
                ->get('/account', 'index')
                ->patch('/account', 'update')
                ->delete('/account', 'destroy');
        }
    );