<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;

class UserController
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->authService->userAccessOnly();
    }

    public function index()
    {
        $user = $this->userService->getById($_SESSION['user_id']);
        
        return View::render(
            'pages.account',
            ['user' => $user]
        );
    }

    public function update()
    {
        handle_csrf();

        $this->userService->updateName($_SESSION['user_id'], $_POST['name']);
        
        back();
    }

    public function destroy()
    {
        handle_csrf();

        if (!$this->userService->deleteUser($_SESSION['user_id'])) {
            back();
        }

        $this->authService->logout();
        $_SESSION['flash_success_msg'] = 'Your account was successfully deleted.';
        
        redirect('/');
    }
}
