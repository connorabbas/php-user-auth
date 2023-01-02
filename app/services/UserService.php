<?php

namespace App\Services;

use App\Models\User;

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

    public function deleteUser($userId)
    {
        return $this->userData->delete($userId);
    }
}
