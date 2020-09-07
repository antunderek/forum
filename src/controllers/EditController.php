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
        $threads = $this->getDataFromModel($name);
        $editview = new EditView();
        $editview->renderPage('edit_thread.php', $threads);
        unset($_GET['thread']);
    }

    private function getDataFromModel($name) {
        $model = new ThreadModel($this->db);
        return $model->getThread($name);
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