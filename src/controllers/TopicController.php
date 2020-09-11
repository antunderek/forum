<?php

namespace controllers;
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
            $this->redirectTo404();
            header('Location: /');
        }
        $thread = $_GET['thread'];
        $topics = $this->getThreadTopics($thread);
        $homeView = new TopicView();
        $homeView->renderPage('topics', $topics);
    }

    // Grab all posts concerning topic, order them by date created
    public function posts() {
        if (empty($_GET['topic'])) {
            echo 'here goes 404';
            die();
        }
        $topicId = $_GET['topic'];
        $topic = $this->getTopic($topicId);
        $topicId = $topic->getId();
        if (!isset($topicId)) {
            echo 'here goes 404';
            die();
        }
        $postsUsers = $this->getPostsUsers($topicId);
        $data = ['topic' => $topic, 'postsUsers' => $postsUsers];
        $postsView = new PostView();
        $postsView->renderPage('posts', $data);
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

    private function getPostsUsers($topicId) {
        $userModel = new UserModel($this->db);
        $postModel = new PostModel($this->db);
        $posts = $postModel->getPosts($topicId);
        $usersPosts = array();
        foreach ($posts as $post) {
            $user = $userModel->getUserById($post->getUser());
            $usersPosts[] = [
                'post' => $post,
                'user' => $user,
            ];
        }
        return $usersPosts;
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
        $editview->renderPage('editTopic', $topics);
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