<?php

namespace controllers;
use classes\ParamsHandler;
use classes\SessionWrapper;
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

    public function posts() {
        if (empty($_GET['topic'])) {
            $this->redirectTo404();
        }
        $topicId = $_GET['topic'];
        $topic = $this->getTopic($topicId);
        $user = $this->getTopicCreator($topic->getTopicCreator());
        $topicId = $topic->getId();
        if (!isset($topicId)) {
            $this->redirectTo404();
        }
        $postsUsers = $this->getPostsUsers($topicId);
        $data = ['topic' => $topic, 'user' => $user, 'postsUsers' => $postsUsers];
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

    private function getTopicCreator($userId) {
        $userModel = new UserModel($this->db);
        return $userModel->getUserById($userId);
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
        if (!$this->checkUser()) {
            $this->redirectTo404();
        }
        if (!isset($_GET['topic']) || $_GET['topic'] === 'newtopic') {
            $topics = [];
        } else {
            $id = $_GET['topic'];
            $topics[] = $this->getDataFromModel($id);
            if (($topics[0]->getTopicCreator() !== SessionWrapper::get('name')) && !SessionWrapper::has('administrator')) {
                $this->redirectTo404();
            }
        }

        $editview = new TopicView();
        $editview->renderPage('editTopic', $topics);
    }

    private function checkUser() {
        return SessionWrapper::has('id');
    }

    private function getDataFromModel($id) {
        return $this->topicModel->getTopic($id);
    }

    private function passUpdateData($params) {
        return $this->topicModel->editTopic($params);
    }

    private function passCreateData($params) {
        $this->topicModel->addNewTopic($params);
    }

    private function passDeleteData($params) {
        return $this->topicModel->removeTopic($_GET['topic']);
    }

    public function update() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        $currentThread = ParamsHandler::getSafe('current_thread');
        if (!$this->passUpdateData($this->paramshandler->retreiveData())) {
            $this->redirectTo404();
        }
        $this->redirect("/topic/index?thread={$currentThread}");
    }

    public function create() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        $currentThread = $_POST['current_thread'];
        $this->passCreateData($this->paramshandler->retreiveData());
        $this->redirect("/topic/index?thread={$currentThread}");
    }

    public function delete() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        if (ParamsHandler::has('topic')) {
            $currentThread = ParamsHandler::getSafe('thread');
            if (!$this->passDeleteData($this->paramshandler->retreiveData())) {
                $this->redirectTo404();
            }
            $this->redirect("/topic/index?thread={$currentThread}");
        }
        else {
            $this->redirectTo404();
        }
    }
}