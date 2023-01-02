<?php

namespace App\Interfaces;

interface UserDataInterface
{
    public function getAll();
    public function getById($id);
    public function getByUsername($username, $email);
    public function create($name, $email, $username, $password);
    public function update($userId, array $properties);
    public function delete($userId);
}