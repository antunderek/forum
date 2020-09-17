<?php

namespace controllers;

use classes\SessionWrapper;
use models\UserModel;
use views\LoginView;

class LoginController extends Controller {
    public function index() {
        $loginview = new LoginView();
        $loginview->renderPage('login');
        SessionWrapper::unset('temp_data');
        SessionWrapper::unset('login_error');
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
            $this->redirect('/login');
        }
        else {
            $this->redirect('/');
        }
    }
}