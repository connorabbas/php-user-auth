<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Validation\Exceptions\UserDataException;

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

    public function updateName($user, $newName)
    {
        $props = [
            'name' => $newName,
        ];
        if ($user->name == $newName) {
            throw new UserDataException('Name was NOT updated. Please enter a different name.');
        }

        return $this->userData->update($user->id, $props);
    }

    public function deleteUser($userId)
    {
        return $this->userData->delete($userId);
    }
}
