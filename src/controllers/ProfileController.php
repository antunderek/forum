<?php

namespace controllers;
use PDO;

use views\ProfileView;
use models\UserModel;
use classes\SessionWrapper;
use classes\ImageUpload;

class ProfileController extends Controller
{
    protected $userModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userModel = new UserModel($db);
    }

    public function index()
    {
        if (!SessionWrapper::has('id')) {
            $this->redirectTo404();
        }
        $adminview = new ProfileView();
        $user[] = $this->getDataFromModel();
        $adminview->renderPage('profile', $user);
    }

    private function getDataFromModel()
    {
        return $this->userModel->getUserById(SessionWrapper::get('id'));
    }

    // Update user profile
    public function update() {
        $params = $this->paramshandler->retreiveData();
        $this->userModel->updateUsernameEmail(SessionWrapper::get('id'), $params);
    }

    public function password() {
        $params = $this->paramshandler->retreiveData();
        $this->userModel->changePassword(SessionWrapper::get('id'), $params);
    }

    // Deletes user profile
    public function delete() {
        if (SessionWrapper::has('administrator') || SessionWrapper::has('id')) {
            $this->userModel->removeUser(SessionWrapper::get('id'));
            header('Location: /logout');
        }
        else {
            echo "You have to log in to access this page";
            die();
        }
    }

    public function image() {
        $imgUpload = new ImageUpload();
        $img = $imgUpload->upload();
        $this->userModel->changeProfilePicture(SessionWrapper::get('id'), $img);
    }
}