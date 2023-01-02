<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Validation\ValidateUser;

class UserService
{
    public $userData;

    public function __construct(User $user)
    {
        $this->userData = $user;
    }

    public function getById($id)
    {
        return $this->userData->getById($id);
    }

    public function createUser($name, $email, $username, $pwd)
    {
        return $this->userData->create($name, $email, $username, $pwd);
    }

    public function deleteUserNew($userId)
    {
        return $this->userData->delete($userId);
    }

    public function updateUserProperties($userId, array $properties)
    {
        return $this->userData->update($userId, $properties);
    }

    // needs rework
    public function updateName($userId, $newName)
    {
        $props = [
            'name' => $newName,
        ];

        try {
            if ($this->userData->getById($userId)->name == $newName) {
                $_SESSION['flash_error_msg'] = 'Name was NOT updated. Please enter a different name.';
                return false;
            }
            if (!$this->userData->update($userId, $props)) {
                $_SESSION['flash_error_msg'] = 'Something went wrong, name was not updated.';
                return false;
            }
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
            if (!$this->userData->delete($userId)) {
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
