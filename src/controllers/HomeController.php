<?php

namespace controllers;

use PDO;
use views\HomeView;
use models\HomeModel;
use classes\User;

class HomeController {
    protected $homeview;
    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->homeview = new HomeView;
    }

    public function index() {
        $homeview = new HomeView();
        $homeview->renderPage();
        //$this->getData($homeview->getPost());
        $this->getData($this->getParams());
    }

    public function getData($postData) {
        $model = new HomeModel($this->db);
        $model->addData($postData);
    }

    private function getParams() {
        return isset($_POST['user'], $_POST['pass']) ? new User($_POST['user'], $_POST['pass']) : null;
    }
}