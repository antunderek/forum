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
        $homeview->setData($threads);
        $homeview->renderPage('home.php');
    }

    public function getDataFromModel() {
        $model = new ThreadModel($this->db);
        return $model->getThreads();
    }
}