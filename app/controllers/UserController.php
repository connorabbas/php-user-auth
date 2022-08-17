<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;

class UserController
{
    protected $db;
    private $auth;
    private $user;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db);
        $this->auth->userAccessOnly();
        $this->user = new User($this->db);
    }

    public function index()
    {
        $user = $this->user->getById($_SESSION['user_id']);
        
        return View::show('pages.user', [
            'user' => $user
        ]);
    }

    public function updateName()
    {
        $name = $_POST['name'];

        if (csrfValid()) {
            if ($this->user->updateName($_SESSION['user_id'], $name)) {
                $_SESSION['user_name'] = $name;
                $_SESSION['flash_success_msg'] = 'Success! Your name has been updated.';
            } else {
                $_SESSION['flash_error_msg'] = 'Something went wrong, name was not updated.';
            }
        } else {
            $_SESSION['flash_error_msg'] = 'Invalid submission. Possible cross site request forgery detected.';
        }

        redirect('/account');
    }
}
