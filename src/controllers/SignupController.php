<?php

namespace controllers;

use views\SignupView;
use models\UserModel;

class SignupController extends Controller {
    public function index() {
        $homeview = new SignupView();
        $homeview->renderPage('signup.php');
    }

    public function passDataToModel($postData) {
        $model = new UserModel($this->db);
        $model->addUser($postData);
    }

    public function register() {
        $this->passDataToModel($this->getParams());
    }
}