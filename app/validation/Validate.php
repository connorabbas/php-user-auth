<?php

namespace App\Validation;

class Validate
{
    public function checkEmptyInputs(array $values): bool
    {
        foreach ($values as $value) {
            if (empty($value)) {
                return true;
            }
        }

        return false;
    }

    public function invalidUsername($username): bool
    {
        return (!preg_match('/^[a-zA-Z0-9]*$/', $username)) ? true : false;
    }

    public function invalidEmail($email): bool
    {
        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    public function pwdMatch($pwd, $pwdR): bool
    {
        return ($pwd !== $pwdR) ? true : false;
    }
}
