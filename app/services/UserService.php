<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Validation\ValidateUser;

class UserService
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser($name, $email, $username, $pwd, $pwdR): bool
    {
        try {
            (New ValidateUser($this->user))->validateRegisterUser($name, $email, $username, $pwd, $pwdR);
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = array_merge(['Not Registered.'], explode(' - ', $e->getMessage()));
            return false;
        }

        try {
            $this->user->create($name, $email, $username, $pwd);
            return true;
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e->getMessage();
            return false;
        }
    }

    public function updateName($userId, $newName)
    {
        $props = [
            'name' => $newName,
        ];

        try {
            if ($this->user->getById($userId)->name == $newName) {
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
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($userId)
    {
        try {
            if (!$this->user->delete($userId)) {
                $_SESSION['flash_error_msg'] = 'Something went wrong, account was NOT deleted.';
                return false;
            }
            return true;
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e->getMessage();
            return false;
        }
    }
}
