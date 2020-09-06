<?php

namespace controllers;

use views\HomeView;
use models\ThreadModel;

class HomeController extends Controller
{
    public function index()
    {
        $threads = $this->getDataFromModel();
        $homeview = new HomeView();
        $homeview->renderPage('home.php', $threads);
    }

    public function getDataFromModel() {
        $model = new ThreadModel($this->db);
        return $model->getAllData();
    }
}