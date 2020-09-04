<?php

namespace controllers;

use views\LoginView;
use models\UserModel;
use classes\SessionWrapper;

class LoginController extends Controller {
    public function index() {
        $loginview = new LoginView();
        $loginview->renderPage('signin.php');
        if ($this->checkErrors()) {
            echo SessionWrapper::get('login_error');
            SessionWrapper::end('login_error');
        }
        SessionWrapper::end('temp_data');
    }

    private function passDataToModel($postData) {
        $model = new UserModel($this->db);
        $model->loginUser($postData);
    }

    private function checkErrors() {
        return SessionWrapper::has('login_error');
    }

    public function signin() {
        $this->passDataToModel($this->getParams());
        if ($this->checkErrors()) {
            header('Location: /login');
        }
        else {
            header('Location: /');
        }
    }
}