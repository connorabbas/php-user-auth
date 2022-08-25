<?php

use App\Controllers\UserController;

// Valid Routes for Site

$router->get('/account', [UserController::class, 'index']);
$router->post('/account', [UserController::class, 'update']);
$router->post('/delete-account', [UserController::class, 'destroy']);
