<?php

namespace App\Controllers;

use Exception;
use App\Core\View;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Validation\ValidateUpdateUsersName;

class UserController
{
    public $authService;
    public $userModel;
    private $currentUser;

    public function __construct(AuthService $authService, UserModel $userModel)
    {
        $this->authService = $authService;
        $this->currentUser = $this->authService->getCurrentUser();
        $this->authService->userAccessOnly($this->currentUser);
        $this->userModel = $userModel;
    }

    public function index()
    {
        return View::render('pages.account', ['user' => $this->currentUser]);
    }

    public function update()
    {
        handle_csrf();

        $newName = request()->input('name');
        $validationErrors = (new ValidateUpdateUsersName($this->currentUser, $newName))->handle();
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userModel->update($this->currentUser->id, ['name' => $newName]);
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
            $this->userModel->deleteById($_SESSION['user_id']);
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
