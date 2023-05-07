<?php

namespace App\Controllers\Auth;

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
        handle_csrf();

        $this->authService->logout();

        return redirect('/');
    }
}
