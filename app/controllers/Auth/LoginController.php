<?php

namespace App\Controllers\Auth;

use App\Core\View;
use App\Services\AuthService;

class LoginController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->authService->guestAccessOnly();
    }

    public function index()
    {
        return View::render('pages.auth.login');
    }

    public function doLogin()
    {
        handleCsrf();
        
        if (!$this->authService->attemptLogin($_POST['username'], $_POST['password'])) {
            back();
        }

        redirect('/');
    }
}
