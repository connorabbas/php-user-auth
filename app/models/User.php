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
    `userID` int(11) NOT NULL AUTO_INCREMENT,
    `userRole` int(1) NOT NULL DEFAULT 0,
    `userName` varchar(128) NOT NULL,
    `userEmail` varchar(128) NOT NULL,
    `userUID` varchar(128) NOT NULL,
    `userPwd` varchar(128) NOT NULL,
    PRIMARY KEY (`userID`)
    )
    */
}