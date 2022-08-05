<?php

namespace App\Controllers\Auth;

use App\Controllers\SiteController;

class LogoutController extends SiteController
{
    public function doLogout()
    {
        session_unset();
        session_destroy();
        header("location: /");
        exit();
    }
}
