<?php

namespace App\Models;

class User
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function modelFunction()
    {
        //
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
    )
    */
}