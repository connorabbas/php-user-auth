<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Models\User;
use App\Services\AuthService;

class LogoutController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function doLogout()
    {
        handleCsrf();
        
        $this->authService->logout();

        redirect('/');
    }
}
