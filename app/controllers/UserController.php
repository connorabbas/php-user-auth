<?php

namespace App\Controllers;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;
use App\Validation\Exceptions\UserDataException;

class UserController
{
    public $authService;
    public $userService;
    private $currentUser;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->currentUser = current_user();
        $this->authService = $authService;
        $this->authService->userAccessOnly($this->currentUser);
        $this->userService = $userService;
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

        try {
            $this->userService->updateName($this->currentUser, $newName);
            $_SESSION['flash_success_msg'] = 'Success! Your name has been updated.';
        } catch (UserDataException $e) {
            $_SESSION['flash_error_msg'] = $e->getMessage();
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
