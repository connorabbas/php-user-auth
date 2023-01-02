<?php

namespace App\Validation;

use App\Interfaces\UserDataInterface;

class ValidateUserRegistration extends Validate
{
    public $userData;
    public $name;
    public $email;
    public $username;
    public $pwd;
    public $pwdR;

    public function __construct(UserDataInterface $userData, $name, $email, $username, $pwd, $pwdR)
    {
        $this->userData = $userData;
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->pwd = $pwd;
        $this->pwdR = $pwdR;
    }

    public function handle(): array
    {
        $errors = [];
        if ($this->checkEmptyInputs([$this->name, $this->email, $this->username, $this->pwd, $this->pwdR]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if ($this->invalidUsername($this->username) !== false) {
            $errors[] = 'Invalid username. No special characters allowed.';
        }
        if ($this->invalidPassword($this->pwd) !== false) {
            $errors[] = 'Invalid password. Must contain the following: Minimum 8 characters in length, ' .
            'At least one uppercase English letter, At least one lowercase English letter, ' .
            'At least one digit, At least one special character.';
        }
        if ($this->match($this->pwd, $this->pwdR) !== false) {
            $errors[] = 'Passwords must match.';
        }
        if ($this->userData->getByUsername($this->username, $this->email) !== false) {
            $errors[] = 'This username or email already exists.';
        }
        
        return $errors;
    }
}
