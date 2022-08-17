<?php

namespace App\Controllers\Auth;

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
