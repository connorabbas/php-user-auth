<?php

namespace App\Validation;

use App\Interfaces\UserDataInterface;

class ValidateUser extends Validate
{
    public $userData;

    public function __construct(UserDataInterface $userData)
    {
        $this->userData = $userData;
    }
    
    public function validateRegisterUser($name, $email, $username, $pwd, $pwdR): array
    {
        $errors = [];
        if ($this->checkEmptyInputs([$name, $email, $username, $pwd, $pwdR]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if ($this->invalidUsername($username) !== false) {
            $errors[] = 'Invalid username. No special characters allowed.';
        }
        if ($this->invalidPassword($pwd) !== false) {
            $errors[] = 'Invalid password. Must contain the following: Minimum 8 characters in length, ' .
            'At least one uppercase English letter, At least one lowercase English letter, ' .
            'At least one digit, At least one special character.';
        }
        if ($this->match($pwd, $pwdR) !== false) {
            $errors[] = 'Passwords must match.';
        }
        if ($this->userData->getByUsername($username, $email) !== false) {
            $errors[] = 'This username or email already exists.';
        }
        
        return $errors;
    }

    public function validateLoginUser($username, $pwd, $user): array
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
        
        return $errors;
    }

    public function validateUpdateUserName($user, $newName): array
    {
        $errors = [];
        if ($user->name == $newName) {
            $errors[] = 'Name was NOT updated. Please enter a different name.';
        }
        
        return $errors;
    }
}
