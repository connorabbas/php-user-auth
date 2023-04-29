<?php

namespace App\Controllers;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Interfaces\UserDataInterface;
use App\Validation\ValidateUpdateUsersName;

class UserController
{
    public $authService;
    public $userData;
    private $currentUser;

    public function __construct(AuthService $authService, UserDataInterface $userData)
    {
        $this->authService = $authService;
        $this->currentUser = $this->authService->getCurrentUser();
        $this->authService->userAccessOnly($this->currentUser);
        $this->userData = $userData;
    }

    public function index()
    {
        return View::render('pages.account', ['user' => $this->currentUser]);
    }

    public function update()
    {
        handle_csrf();

        $newName = $_POST['name'];
        $validationErrors = (new ValidateUpdateUsersName($this->currentUser, $newName))->handle();
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userData->update($this->currentUser->id, ['name' => $newName]);
            $_SESSION['flash_success_msg'] = 'Success! Your name has been updated.';
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff.';
        }
        
        return back();
    }

    public function destroy()
    {
        handle_csrf();

        try {
            $this->userData->deleteById($_SESSION['user_id']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff.';
            return back();
        }

        $this->authService->logout();
        $_SESSION['flash_success_msg'] = 'Your account was successfully deleted.';
        
        return redirect('/');
    }
}
