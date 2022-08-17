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
    private $auth;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db);
        $this->auth->userAccessOnly();
    }

    public function index()
    {
        $user = (new User($this->db))->getById($_SESSION['user_id']);
        
        return View::show('pages.user', [
            'user' => $user
        ]);
    }

    public function updateName()
    {
        if (csrfValid()) {
            (new UserService($this->db))->updateName($_SESSION['user_id'], $_POST['name']);
        } else {
            $_SESSION['flash_error_msg'] = 'Invalid submission. Possible cross site request forgery detected.';
        }

        redirect('/account');
    }
}
