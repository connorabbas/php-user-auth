<?php

namespace App\MVC\Controllers\Auth;

class LogoutController
{
    public function doLogout()
    {
        handleCsrf();
        
        session_unset();
        session_destroy();
        redirect('/');
    }
}
