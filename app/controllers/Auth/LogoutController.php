<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Controllers\SiteController;

class LogoutController extends SiteController
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function doLogout()
    {
        session_unset();
        session_destroy();
        header("location: /");
        exit();
    }
}
