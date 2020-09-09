<?php

namespace controllers;

use views\HomeView;
use models\ThreadModel;

class HomeController extends Controller
{
    public function index()
    {
        $threads = $this->getThreads();
        $homeview = new HomeView();
        $homeview->renderPage('home.php', $threads);
    }

    public function getThreads() {
        $model = new ThreadModel($this->db);
        return $model->getAllThreads();
    }
}