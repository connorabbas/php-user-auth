<?php

namespace App\Models;

class User
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function create($name, $email, $username, $password)
    {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(name, email, username, password) 
            VALUES(:name, :email, :username, :password);";

        $this->db->query($sql);
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hashedPwd);

        return $this->db->execute();
    }

    function getById($id)
    {
        $sql = "SELECT * FROM users 
            WHERE id = :id;";

        $this->db->query($sql);
        $this->db->bind(':id', $id);

        if ($result = $this->db->single()) {
            return $result;
        }

        return false;
    }

    function getByUsername($username, $email)
    {
        $sql = "SELECT * FROM users 
            WHERE username = :username OR email = :email;";

        $this->db->query($sql);
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);

        if ($result = $this->db->single()) {
            return $result;
        }

        return false;
    }
}
