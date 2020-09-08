<?php

namespace controllers;
use views\TopicView;
use models\TopicModel;

class TopicController extends Controller {
    public function index()
    {
        $topics = $this->getAllTopics();
        $homeview = new TopicView();
        var_dump($topics);
        $homeview->renderPage('topics.php', $topics);
    }

    // Get all topics and get topics of only one thread
    public function getAllTopics() {
        $model = new TopicModel($this->db);
        return $model->getAllTopics();
    }

    public function getThreadTopics() {}

    public function getSingleTopic() {}
}