<?php

namespace App\Models;

use App\Core\Model;
use App\Interfaces\UserDataInterface;

class User extends Model implements UserDataInterface
{
    private $table = 'users';

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";

        $this->db->query($sql);

        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table 
            WHERE id = :id";

        $this->db
            ->query($sql)
            ->bind(':id', $id);

        return $this->db->single();
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM $this->table 
            WHERE email = :email";

        $this->db
            ->query($sql)
            ->bind(':email', $email);

        return $this->db->single();
    }

    public function create($name, $email, $password)
    {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table(name, email, password) 
            VALUES(:name, :email, :password)";

        $this->db
            ->query($sql)
            ->bind(':name', $name)
            ->bind(':email', $email)
            ->bind(':password', $hashedPwd);

        return $this->db->execute();
    }

    public function update($userId, array $properties)
    {
        $setString = '';
        foreach ($properties as $property => $value) {
            $setString .= $property . ' = ' . ':' . $property;
            if ($property != array_key_last($properties)) {
                $setString .= ', ';
            } else {
                $setString .= ' ';
            }
        }

        $sql = "UPDATE $this->table
            SET $setString
            WHERE id = :id";

        $this->db->query($sql);
        foreach ($properties as $property => $value) {
            $this->db->bind(':' . $property, $value);
        }
        $this->db->bind(':id', $userId);

        return $this->db->execute();
    }

    public function deleteById($userId)
    {
        $sql = "DELETE FROM $this->table
            WHERE id = :id";

        $this->db
            ->query($sql)
            ->bind(':id', $userId);

        return $this->db->execute();
    }
}
