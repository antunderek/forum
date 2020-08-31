<?php

namespace controllers;

use PDO;
use views\SignupView;
use models\UserModel;
use classes\User;

class SignupController {
    protected $db;
    //interface za view i ostale, kako bi pristupili svim view class
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function getParams() {
        return isset($_POST['user'], $_POST['pass'], $_POST['email']) ? new User($_POST['user'], $_POST['pass'], $_POST['email']) : null;
    }

    public function index() {
        $homeview = new SignupView();
        $homeview->renderPage();
        $this->getData($this->getParams());
    }

    public function getData($postData) {
        $model = new UserModel($this->db);
        $model->addUser($postData);
    }

    public function register() {
    }
}