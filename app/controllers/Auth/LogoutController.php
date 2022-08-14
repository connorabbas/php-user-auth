<?php

namespace App\Controllers\Auth;

class LogoutController
{
    public function doLogout()
    {
        if (csrfValid()) {
            session_unset();
            session_destroy();
        } else {
            $_SESSION['flash_error_msg'] = 'Invalid logout attempt. Possible cross site request forgery detected.';
        }

        redirect('/');
    }
}
