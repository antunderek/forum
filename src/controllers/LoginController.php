<?php

namespace controllers;

use views\LoginView;
use models\UserModel;

class LoginController extends Controller {
    public function index() {
        $loginview = new LoginView();
        //$loginview->renderPage();
        $loginview->renderPage('signin.php');
    }

    public function passDataToModel($postData) {
        $model = new UserModel($this->db);
        $model->loginUser($postData);
    }

    public function signin() {
        $this->passDataToModel($this->getParams());
    }
}