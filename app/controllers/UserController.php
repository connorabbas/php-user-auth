<?php

namespace App\Controllers;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;
use App\Validation\ValidateUser;

class UserController
{
    public $authService;
    public $userService;
    public $userValidation;
    private $currentUser;

    public function __construct(AuthService $authService, UserService $userService, ValidateUser $userValidation)
    {
        $this->currentUser = current_user();
        $this->authService = $authService;
        $this->authService->userAccessOnly($this->currentUser);
        $this->userService = $userService;
        $this->userValidation = $userValidation;
    }

    public function index()
    {
        return View::render(
            'pages.account',
            ['user' => $this->currentUser]
        );
    }

    public function update()
    {
        handle_csrf();

        $newName = $_POST['name'];
        $validationErrors = $this->userValidation->validateUpdateUserName($this->currentUser, $newName);
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userService->updateUserProperties($this->currentUser->id, ['name' => $newName]);
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
            $this->userService->deleteUser($_SESSION['user_id']);
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
