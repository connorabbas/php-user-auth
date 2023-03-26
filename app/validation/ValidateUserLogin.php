<?php

namespace App\Validation;

class ValidateUserLogin extends Validate
{
    public $email;
    public $pwd;
    public $user;

    public function __construct($email, $pwd, $user)
    {
        $this->email = $email;
        $this->pwd = $pwd;
        $this->user = $user;
    }

    public function handle(): array
    {
        $errors = [];
        if ($this->checkEmptyInputs([$this->email, $this->pwd]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if (!$this->user) {
            $errors[] = 'Cannot find user with matching email.';
        }
        if ($this->user !== false && !password_verify($this->pwd, $this->user->password)) {
            $errors[] = 'Incorrect password.';
        }
        
        return $errors;
    }
}
