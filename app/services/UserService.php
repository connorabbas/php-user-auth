<?php

namespace App\Services;

use App\Core\DB;
use App\Models\User;
use Exception;

class UserService
{
    protected $db;
    public $user;

    public function __construct(DB $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;
    }

    public function updateName($userId, $newName)
    {
        $props = [
            'name' => $newName,
        ];

        try {
            $user = $this->user->getById($userId);
            if ($user->name == $newName) {
                $_SESSION['flash_error_msg'] = 'Name was NOT updated. Please enter a different name.';
                return false;
            }
            if (!$this->user->update($userId, $props)) {
                $_SESSION['flash_error_msg'] = 'Something went wrong, name was not updated.';
                return false;
            }
            $_SESSION['user_name'] = $newName;
            $_SESSION['flash_success_msg'] = 'Success! Your name has been updated.';
            return true;
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e;
            return false;
        }
    }

}
