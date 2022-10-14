<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;

class UserController
{
    protected $db;
    private $authService;
    private $userService;
    private $user;

    public function __construct()
    {
        $this->db = new DB();
        $this->user = new User($this->db);
        $this->authService = new AuthService($this->user);
        $this->userService = new UserService($this->user);
        $this->authService->userAccessOnly();
    }

    public function index()
    {
        $user = $this->user->getById($_SESSION['user_id']);
        
        return View::render('pages.account', [
            'user' => $user
        ]);
    }

    public function update()
    {
        handleCsrf();

        $this->userService->updateName($_SESSION['user_id'], $_POST['name']);
        
        back();
    }

    public function destroy()
    {
        handleCsrf();

        if (!$this->userService->deleteUser($_SESSION['user_id'])) {
            back();
        }

        $this->auth->logout();
        $_SESSION['flash_success_msg'] = 'Your account was successfully deleted.';
        
        redirect('/');
    }
}
