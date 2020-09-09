<?php

namespace controllers;
use views\TopicView;
use views\PostsView;
use models\TopicModel;
use models\PostModel;

class TopicController extends Controller {
    public function index()
    {
        if(!isset($_GET['thread'])) {
            header('Location: /');
        }
        $thread = $_GET['thread'];
        $topics = $this->getThreadTopics($thread);
        $homeView = new TopicView();
        $homeView->renderPage('topics.php', $topics);
    }

    public function posts() {
        // Grab all posts concerning topic, order them by date created
        // $homeview->renderPage('view.php', $posts);
        $topicId = $_GET['topic'];
        $topic = $this->getSingleTopic($topicId);
        $topicId = $topic->getId();
        $posts = $this->getPosts($topicId);
        $data = ['topic' => $topic, 'posts' => $posts];
        $postsView = new PostsView();
        $postsView->renderPage('posts.php', $data);
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

    private function getSingleTopic($topicId) {
        $model = new TopicModel($this->db);
        return $model->getTopic($topicId);
    }

    private function getPosts($topicId) {
        $model = new PostModel($this->db);
        return $model->getPosts($topicId);
    }
}