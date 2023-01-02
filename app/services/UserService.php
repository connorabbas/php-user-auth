<?php

namespace App\Services;

use App\Interfaces\UserDataInterface;

/**
 * Service layer to make the User data an interchangeable class
 */
class UserService
{
    public $userData;

    public function __construct(UserDataInterface $userData)
    {
        $this->userData = $userData;
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
