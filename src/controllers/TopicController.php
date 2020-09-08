<?php

namespace controllers;
use views\TopicView;
use models\TopicModel;

class TopicController extends Controller {
    public function index()
    {
        if(!isset($_GET['thread'])) {
            header('Location: /');
        }
        $thread = $_GET['thread'];
        $topics = $this->getThreadTopics($thread);
        $homeview = new TopicView();
        $homeview->renderPage('topics.php', $topics);
    }

    public function view() {
        // Grab all posts concerning topic, order them by date created
        // $homeview->renderPage('view.php', $posts);
    }

    //public function
    // Get all topics and get topics of only one thread
    private function getAllTopics() {
        $model = new TopicModel($this->db);
        return $model->getAllTopics();
    }

    private function getThreadTopics($thread) {
        $model = new TopicModel($this->db);
        return $model->getThreadTopics($thread);
    }

    private function getSingleTopic() {}
}