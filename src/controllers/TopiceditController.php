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
            $id = $_GET['topic'];
            $topics[] = $this->getDataFromModel($id);
        }
        $editview = new TopiceditView();
        $editview->renderPage('edit_topic.php', $topics);
        unset($_GET['thread']);
    }

    private function getDataFromModel($id) {
        $model = new TopicModel($this->db);
        return $model->getTopic($id);
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
        $model->removeTopic($_GET['topic']);
    }

    public function update() {
        $currentThread = $_GET['current_thread'];
        $this->passUpdateData($this->paramshandler->retreiveData());
        header("Location: /topic/index?thread={$currentThread}");
    }

    public function create() {
        $currentThread = $_GET['current_thread'];
        $this->passCreateData($this->paramshandler->retreiveData());
        header("Location: /topic/index?thread={$currentThread}");
    }

    public function delete() {
        if (isset($_GET['topic'])) {
            $currentThread = $_GET['thread'];
            $this->passDeleteData($this->paramshandler->retreiveData());
            header("Location: /topic/index?thread={$currentThread}");
        }
        else {
            header("Location: /");
        }
    }
}
