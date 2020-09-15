<?php

namespace controllers;
use PDO;

use classes\ParamsHandler;
use views\EditView;
use models\ThreadModel;

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
        if (!$threads) {
            $this->redirectTo404();
        }
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
        return $model->addNewThread($params);
    }

    private function passDeleteData($params) {
        $model = new ThreadModel($this->db);
        $model->removeThread($_GET['thread']);
    }

    public function update() {
        $this->passUpdateData($this->paramshandler->retreiveData());
        $this->redirect('/admin');
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