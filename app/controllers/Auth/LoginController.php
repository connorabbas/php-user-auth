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
        handle_csrf();

        $request = request();
        if (!$this->authService->attemptLogin($request->input('email'), $request->input('password'))) {
            return back();
        }

        return redirect('/');
    }
}
