<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function getById($id)
    {
        $sql = "SELECT * FROM users 
            WHERE id = :id;";

        $this->db->query($sql)
            ->bind(':id', $id);

        if ($result = $this->db->single()) {
            return $result;
        }

        return false;
    }

    public function getByUsername($username, $email)
    {
        $sql = "SELECT * FROM users 
            WHERE username = :username OR email = :email;";

        $this->db->query($sql)
            ->bind(':username', $username)
            ->bind(':email', $email);

        if ($result = $this->db->single()) {
            return $result;
        }

        return false;
    }

    public function create($name, $email, $username, $password)
    {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(name, email, username, password) 
            VALUES(:name, :email, :username, :password);";

        $this->db->query($sql)
            ->bind(':name', $name)
            ->bind(':email', $email)
            ->bind(':username', $username)
            ->bind(':password', $hashedPwd);

        return $this->db->execute();
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

        $sql = "UPDATE users
            SET $setString
            WHERE id = :id";

        $this->db->query($sql);
        foreach ($properties as $property => $value) {
            $this->db->bind(':' . $property, $value);
        }
        $this->db->bind(':id', $userId);

        return $this->db->execute();
    }

    /* 
    CREATE TABLE `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `role` int(1) NOT NULL DEFAULT 0,
        `name` varchar(128) NOT NULL,
        `email` varchar(128) NOT NULL,
        `username` varchar(128) NOT NULL,
        `password` varchar(128) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1
    */
}
