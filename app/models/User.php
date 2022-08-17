<?php

namespace App\Models;

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

    public function updateName(int $userId, string $newName)
    {
        $sql = "UPDATE users
            SET name = :name
            WHERE id = :id";

        $this->db->query($sql)
            ->bind(':name', $newName)
            ->bind(':id', $userId);

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
