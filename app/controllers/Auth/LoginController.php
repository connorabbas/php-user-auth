<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Controllers\SiteController;

class LoginController extends SiteController
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function index()
    {
        return view('pages/login');
    }
}