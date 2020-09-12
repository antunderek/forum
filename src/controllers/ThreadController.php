<?php

namespace controllers;

use classes\ParamsHandler;
use PDO;
use views\EditView;
use models\ThreadModel;
use classes\SessionWrapper;

class ThreadController extends Controller {

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->checkIfAdmin();
    }

    public function edit()
    {
        if (!ParamsHandler::has('thread')) {
            $this->redirectTo404();
        }
        $name = ParamsHandler::get('thread');
        $threads = $this->getDataFromModel($name);
        $editview = new EditView();
        $editview->renderPage('editThread', $threads);
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
        if (ParamsHandler::has('name')) {
            $this->passUpdateData($this->paramshandler->retreiveData());
            $this->redirect('/admin');
        }
        else {
            $this->redirectTo404();
        }
    }

    public function create() {
        $this->passCreateData($this->paramshandler->retreiveData());
        $this->redirect('/admin');
    }

    public function delete() {
        if (ParamsHandler::has('thread')) {
            $this->passDeleteData($this->paramshandler->retreiveData());
            $this->redirect('/admin');
        }
        else {
            $this->redirectTo404();
        }
    }
}