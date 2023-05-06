<?php

namespace App\Models;

use App\Core\Model;

class UserModel extends Model
{
    private $table = 'users';
    private $recordCache = [];

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->db->query($sql);
    }

    public function getById($id)
    {
        if (array_key_exists($id, $this->recordCache)) {
            return $this->recordCache[$id];
        }
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $result = $this->db->single($sql, [$id]);
        $this->recordCache[$id] = $result;

        return $result;
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM $this->table 
            WHERE email = ?";

        return $this->db->single($sql, [$email]);
    }

    public function create($name, $email, $password)
    {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table(name, email, password) 
            VALUES(:name, :email, :password)";

        return $this->db->execute($sql, [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPwd,
        ]);
    }

    public function update(int $userId, array $properties)
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
        $properties['id'] = $userId;
        $sql = "UPDATE $this->table
            SET $setString
            WHERE id = :id";

        return $this->db->execute($sql, $properties);
    }

    public function deleteById(int $userId)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        return $this->db->execute($sql, [$userId]);
    }
}
