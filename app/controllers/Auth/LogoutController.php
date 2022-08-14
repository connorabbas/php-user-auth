<?php

namespace App\Controllers\Auth;

class LogoutController
{
    public function doLogout()
    {
        session_unset();
        session_destroy();
        header("location: /");
        exit();
    }
}
