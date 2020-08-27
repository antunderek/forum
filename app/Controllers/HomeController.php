<?php

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
        $this->getData($homeview->getPost());
    }

    public function getData($postData) {
        $model = new HomeModel($this->db);
        $model->addData($postData);
    }
}