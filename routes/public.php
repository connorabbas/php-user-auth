<?php

use App\Controllers\ExampleController;

// Valid Routes for Site

$router->view('/', 'pages/welcome');
$router->view('/login', 'pages/login');
$router->view('/sign-up', 'pages/sign_up');

$router->get('/example', [ExampleController::class, 'index']);