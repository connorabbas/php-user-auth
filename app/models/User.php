<?php

namespace App\Models;

class User extends Model
{
    function create($name, $email, $username, $password)
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

    function getById($id)
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

    function getByUsername($username, $email)
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
}
