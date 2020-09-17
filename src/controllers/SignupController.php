<?php

namespace controllers;

use classes\SessionWrapper;
use models\UserModel;
use views\SignupView;

class SignupController extends Controller {
    public function index() {
        $homeview = new SignupView();
        $homeview->renderPage('signup');
        SessionWrapper::unset('temp_data');
        SessionWrapper::unset('register_error');
    }

    private function passDataToModel($postData) {
        $model = new UserModel($this->db);
        $model->addUser($postData);
    }

    private function checkErrors() {
        return SessionWrapper::has('register_error');
    }

    public function register()
    {
        $this->passDataToModel($this->getParams());
        if ($this->checkErrors()) {
            $this->redirect('/signup');
        } else {
            $this->redirect('/login');
        }
    }
}