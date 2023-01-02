<?php

namespace App\Validation;

class ValidateUserLogin extends Validate
{
    public $username;
    public $pwd;
    public $user;

    public function __construct($username, $pwd, $user)
    {
        $this->username = $username;
        $this->pwd = $pwd;
        $this->user = $user;
    }

    public function handle(): array
    {
        $errors = [];
        if ($this->checkEmptyInputs([$this->username, $this->pwd]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if (!$this->user) {
            $errors[] = 'Cannot find user with matching username or email.';
        }
        if ($this->user !== false && !password_verify($this->pwd, $this->user->password)) {
            $errors[] = 'Incorrect password.';
        }
        
        return $errors;
    }
}
