<?php

namespace App\Validation;

use Exception;
use App\Models\User;

class ValidateUser extends Validate
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function validateRegisterUser($name, $email, $username, $pwd, $pwdR): void
    {
        $errors = [];
        if ($this->checkEmptyInputs([$name, $email, $username, $pwd, $pwdR]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if ($this->invalidUsername($username) !== false) {
            $errors[] = 'Invalid username.';
        }
        if ($this->pwdMatch($pwd, $pwdR) !== false) {
            $errors[] = 'Passwords must match.';
        }
        if ($this->user->getByUsername($username, $email) !== false) {
            $errors[] = 'This username or email already exists.';
        }
        if (count($errors)) {
            throw new Exception(implode(' - ', $errors));
        }
    }

    public function validateLoginUser($username, $pwd, $user): void
    {
        $errors = [];
        if ($this->checkEmptyInputs([$username, $pwd]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if (!$user) {
            $errors[] = 'Cannot find user with matching username or email.';
        }
        if ($user !== false && !password_verify($pwd, $user->password)) {
            $errors[] = 'Incorrect password.';
        }
        if (count($errors)) {
            throw new Exception(implode(' - ', $errors));
        }
    }
}
