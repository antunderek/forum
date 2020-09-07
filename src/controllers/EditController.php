<?php

namespace controllers;

use views\EditView;
use models\ThreadModel;
use classes\SessionWrapper;

class EditController extends Controller {
    //construct provjeri da li je administrator
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
        unset($_GET['thread'], $_GET['subthread']);
    }

    private function getDataFromModel($name, $type = THREAD, $thread_name = null) {
        $model = new ThreadModel($this->db);
        return $model->getData($name, $type, $thread_name);
    }

    private function getAllThreadSubthreads($thread_name) {
        $model = new ThreadModel($this->db);
        return $model->getThreadsSubthreads($thread_name);
    }

    private function passUpdateData($params) {
        $model = new ThreadModel($this->db);
        $model->editThread($params);
    }

    private function passCreateData($params) {
        $model = new ThreadModel($this->db);
        $model->addNewThread($params);
    }

    private function passDeleteData($params) {
        $model = new ThreadModel($this->db);
        $model->removeThread($_GET['thread']);
    }

    public function update() {
        $this->passUpdateData($this->paramshandler->retreiveData());
    }

    public function create() {
        $this->passCreateData($this->paramshandler->retreiveData());
    }

    public function delete() {
        if (isset($_GET['thread'])) {
            $this->passDeleteData($this->paramshandler->retreiveData());
            header('Location: /admin');
        }
    }
}