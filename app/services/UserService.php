<?php

namespace App\Services;

use App\Core\DB;
use App\Models\User;

class UserService
{
    protected $db;
    public $user;

    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->user = new User($this->db);
    }

    public function updateName($userId, $name)
    {
        $props = [
            'name' => $name,
        ];

        if ($this->user->update($userId, $props)) {
            $_SESSION['user_name'] = $name;
            $_SESSION['flash_success_msg'] = 'Success! Your name has been updated.';
        } else {
            $_SESSION['flash_error_msg'] = 'Something went wrong, name was not updated.';
        }
    }

}
