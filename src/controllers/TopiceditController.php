<?php

namespace controllers;
use models\TopicModel;
use views\TopiceditView;
use classes\SessionWrapper;

class TopiceditController extends Controller {
    // create interface for editor controllers
    // construct check if user administrator or owner of the topic
    public function index()
    {
        if (!isset($_GET['topic']) || $_GET['topic'] === 'newtopic') {
            // redirect to create new topic
            // echo 'here goes 404 controller';
            // die();
            $topics = [];
        } else {
            $name = $_GET['topic'];
            $topics = $this->getDataFromModel($name);
        }
        $editview = new TopiceditView();
        $editview->renderPage('edit_topic.php', $topics);
        unset($_GET['thread']);
    }

    private function getDataFromModel($name) {
        $model = new TopicModel($this->db);
        return $model->getTopic($name);
    }

    private function passUpdateData($params) {
        $model = new TopicModel($this->db);
        $model->editTopic($params);
    }

    private function passCreateData($params) {
        $model = new TopicModel($this->db);
        $model->addNewTopic($params);
    }

    private function passDeleteData($params) {
        $model = new TopicModel($this->db);
        $model->removeTopic($_GET['thread']);
    }

    public function update() {
        $this->passUpdateData($this->paramshandler->retreiveData());
        header('Location: /');
    }

    public function create() {
        $this->passCreateData($this->paramshandler->retreiveData());
        header('Location: /');
    }

    public function delete() {
        if (isset($_GET['thread'])) {
            $this->passDeleteData($this->paramshandler->retreiveData());
            header('Location: /');
        }
    }
}
