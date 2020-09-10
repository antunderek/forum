<?php

namespace controllers;
use classes\User;
use models\UserModel;
use PDO;

use views\TopicView;
use views\PostView;
use models\TopicModel;
use models\PostModel;

class TopicController extends Controller {
    protected $topicModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->topicModel = new TopicModel($this->db);
    }

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
        $topic = $this->getTopic($topicId);
        $topicId = $topic->getId();
        $posts = $this->getPosts($topicId);
        $users = $this->getUsers($posts);
        $data = ['topic' => $topic, 'posts' => $posts];
        $postsView = new PostView();
        $postsView->renderPage('posts.php', $data);
    }

    private function getAllTopics() {
        return $this->topicModel->getAllTopics();
    }

    private function getThreadTopics($thread) {
        return $this->topicModel->getThreadTopics($thread);
    }

    private function getTopic($topicId) {
        return $this->topicModel->getTopic($topicId);
    }

    private function getPosts($topicId) {
        $model = new PostModel($this->db);
        return $model->getPosts($topicId);
    }

    private function getUsers($posts) {
        $model = new UserModel($this->db);
        $users = array();
        foreach ($posts as $post) {
            $user[] = $model->getUserById($post->getUser());
        }
        return $users;
    }


    public function edit()
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
        $editview = new TopicView();
        $editview->renderPage('editTopic.php', $topics);
        unset($_GET['thread']);
    }

    private function getDataFromModel($id) {
        return $this->topicModel->getTopic($id);
    }

    private function passUpdateData($params) {
        $this->topicModel->editTopic($params);
    }

    private function passCreateData($params) {
        $this->topicModel->addNewTopic($params);
    }

    private function passDeleteData($params) {
        $this->topicModel->removeTopic($_GET['topic']);
    }

    public function update() {
        $currentThread = $_POST['current_thread'];
        $this->passUpdateData($this->paramshandler->retreiveData());
        header("Location: /topic/index?thread={$currentThread}");
    }

    public function create() {
        $currentThread = $_POST['current_thread'];
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