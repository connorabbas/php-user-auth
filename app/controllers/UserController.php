<?php

namespace App\Controllers;

use App\Core\DB;

class UserController extends SiteController
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function index()
    {
        //
    }
}
