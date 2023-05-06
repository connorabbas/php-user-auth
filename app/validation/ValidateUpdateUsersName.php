<?php

namespace App\Validation;

class ValidateUpdateUsersName extends Validate
{
    public $user;
    public $newName;

    public function __construct($user, $newName)
    {
        $this->user = $user;
        $this->newName = $newName;
    }

    public function handle(): array
    {
        $errors = [];
        if ($this->user->name == $this->newName) {
            $errors[] = 'Name was NOT updated. Please enter a different name.';
        }
        
        return $errors;
    }
}
