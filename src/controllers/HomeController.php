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
        $threads = $model->getAllThreadsOrSubthreads(THREAD);
        $subthreads = null;
        foreach ($threads as $thread) {
            $thread_name = $thread->getName();
            $subthreads[$thread_name] = $model->getThreadsSubthreads($thread_name);
        }
        $threads_subthreads = ['threads' => $threads, 'subthreads' => $subthreads];
        return $threads_subthreads;
    }
}