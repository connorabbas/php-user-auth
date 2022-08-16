<?php

use App\Controllers\UserController;

// Valid Routes for Site

$router->view('/', 'pages.welcome');

$router->get('/user-info', [UserController::class, 'index']);

