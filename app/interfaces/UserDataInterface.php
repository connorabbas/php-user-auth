<?php

namespace App\Interfaces;

interface UserDataInterface
{
    public function getAll();
    public function getById($id);
    public function getByEmail($email);
    public function create($name, $email, $password);
    public function update($userId, array $properties);
    public function deleteById($userId);
}