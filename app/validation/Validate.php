<?php

namespace App\Validation;

abstract class Validate
{
    abstract protected function handle(): array;

    /**
     * Ensure input entries are not empty
     *
     * @param array $values
     * @return boolean
     */
    public function checkEmptyInputs(array $values): bool
    {
        foreach ($values as $value) {
            if (empty($value)) {
                return true;
            }
        }

        return false;
    }

    public function invalidEmail($email): bool
    {
        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    /**
     * Minimum 8 characters in length
     * At least one uppercase English letter
     * At least one lowercase English letter
     * At least one digit
     * At least one special character
     */
    public function invalidPassword($password): bool
    {
        return (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) ? true : false;
    }

    public function match($input, $inputR): bool
    {
        return ($input !== $inputR) ? true : false;
    }
}
