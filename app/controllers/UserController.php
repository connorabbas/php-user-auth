<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;

class UserController
{
    public $authService;
    public $userService;
    private $currentUser;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->currentUser = current_user();
        $this->authService = $authService;
        $this->authService->userAccessOnly($this->currentUser);
        $this->userService = $userService;
    }

    public function index()
    {
        return View::render(
            'pages.account',
            ['user' => $this->currentUser]
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
