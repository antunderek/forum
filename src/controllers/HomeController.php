<?php

namespace controllers;

use models\ThreadModel;
use views\HomeView;

class HomeController extends Controller
{
    public function index()
    {
        $threads = $this->getThreads();
        $homeview = new HomeView();
        $homeview->renderPage('home', $threads);
    }

    public function getThreads() {
        $model = new ThreadModel($this->db);
        return $model->getAllThreads();
    }
}