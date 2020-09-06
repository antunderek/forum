<?php

namespace controllers;

use views\EditView;
use models\ThreadModel;
use classes\SessionWrapper;

class EditController extends Controller {
    public function index()
    {
        if (!isset($_GET['thread']) || !SessionWrapper::has('administrator')) {
            echo 'here goes 404 controller';
            die();
        }
        $name = $_GET['thread'];
        if (isset($_GET['subthread'])) {
            $threads = $this->getDataFromModel($_GET['subthread'], SUBTHREAD, $name);
        }
        else {
            $threads = $this->getDataFromModel($name);
            $threads['subthreads'] = $this->getAllThreadSubthreads($name);
        }
        $editview = new EditView();
        $editview->renderPage('edit_thread.php', $threads);
        unset($_GET['thread']);
        unset($_GET['subthread']);
    }

    private function getDataFromModel($name, $type = THREAD, $thread_name = null) {
        $model = new ThreadModel($this->db);
        return $model->getData($name, $type, $thread_name);
    }

    private function getAllThreadSubthreads($thread_name) {
        $model = new ThreadModel($this->db);
        return $model->getAllData(SUBTHREAD, $thread_name);
    }
}