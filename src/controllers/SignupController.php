<?php

namespace controllers;

use views\SignupView;
use models\UserModel;
use classes\SessionWrapper;

class SignupController extends Controller {
    public function index() {
        $homeview = new SignupView();
        $homeview->renderPage('signup.php');
        if ($this->checkErrors()) {
            //Dodati u html i posebno renderati?
            echo SessionWrapper::get('register_error');
            SessionWrapper::end('register_error');
        }
    }

    private function passDataToModel($postData) {
        $model = new UserModel($this->db);
        $model->addUser($postData);
    }

    private function checkErrors() {
        return SessionWrapper::has('register_error');
    }

    public function register() {
        $this->passDataToModel($this->getParams());
        if ($this->checkErrors()) {
            header('Location: /signup');
        }
    }
}