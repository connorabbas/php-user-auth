<?php

namespace App\Validation;

use App\Models\UserModel;

class ValidateUserRegistration extends Validate
{
    public $userModel;
    public $name;
    public $email;
    public $pwd;
    public $pwdR;

    public function __construct(UserModel $userModel, $name, $email, $pwd, $pwdR)
    {
        $this->userModel = $userModel;
        $this->name = $name;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdR = $pwdR;
    }

    public function handle(): array
    {
        $errors = [];
        if ($this->checkEmptyInputs([$this->name, $this->email, $this->pwd, $this->pwdR]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if ($this->invalidPassword($this->pwd) !== false) {
            $errors[] = 'Invalid password. Must contain the following: Minimum 8 characters in length, ' .
            'At least one uppercase English letter, At least one lowercase English letter, ' .
            'At least one digit, At least one special character.';
        }
        if ($this->match($this->pwd, $this->pwdR) !== false) {
            $errors[] = 'Passwords must match.';
        }
        if ($this->userModel->getByEmail($this->email) !== false) {
            $errors[] = 'This email is already in use.';
        }

        return $errors;
    }
}
