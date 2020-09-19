<?php

namespace controllers;
use PDO;

use classes\ParamsHandler;
use classes\SessionWrapper;

use models\UserModel;
use models\TopicModel;
use models\PostModel;
use models\ThreadModel;

use views\TopicView;
use views\PostView;


class TopicController extends Controller {
    protected $topicModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->topicModel = new TopicModel($this->db);
    }

    public function index()
    {
        if (!ParamsHandler::has('id')) {
            $this->redirectTo404();
        }
        $thread = ParamsHandler::get('id');
        $thread = $this->getThread($thread);
        if (!$thread) {
            $this->redirectTo404();
        }
        $topics = $this->getThreadTopics($thread->getId());
        $data = ['topics' => $topics, 'thread' => $thread];
        $homeView = new TopicView();
        $homeView->renderPage('topics', $data);
    }

    public function posts() {
        if (!ParamsHandler::has('topic')) {
            $this->redirectTo404();
        }
        $topicId = ParamsHandler::get('topic');
        $topic = $this->getTopic($topicId);
        if (!$topic) {
            $this->redirectTo404();
        }
        $user = $this->getTopicCreator($topic->getTopicCreator());
        $topicId = $topic->getTopicId();
        if (!isset($topicId)) {
            $this->redirectTo404();
        }
        $postsUsers = $this->getPostsUsers($topicId);
        $data = ['topic' => $topic, 'user' => $user, 'postsUsers' => $postsUsers];
        $postsView = new PostView();
        $postsView->renderPage('posts', $data);
    }

    private function getThread($id) {
        $model = new ThreadModel($this->db);
        return $model->getThread($id);
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
        if (!ParamsHandler::has('topic') || ParamsHandler::get('topic') === 'newtopic') {
            $topics = [];
        } else {
            $id = ParamsHandler::get('topic');
            $topics[] = $this->getDataFromModel($id);
            if (($topics[0]->getTopicCreator() !== SessionWrapper::get('id')) && !SessionWrapper::has('administrator')) {
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
        return $this->topicModel->removeTopic(ParamsHandler::get('topic'));
    }

    public function update() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        $currentThread = ParamsHandler::get('thread');
        if (!$this->passUpdateData($this->paramshandler->retreiveData())) {
            $this->redirectTo404();
        }
        $this->redirect("/topic/index?id={$currentThread}");
    }

    public function create() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        $currentThread = ParamsHandler::get('thread');
        $this->passCreateData($this->paramshandler->retreiveData());
        $this->redirect("/topic/index?id={$currentThread}");
    }

    public function delete() {
        if (!$this->checkUser() && !SessionWrapper::get('administrator')) {
            $this->redirectTo404();
        }
        if (ParamsHandler::has('topic')) {
            $currentThread = ParamsHandler::get('thread');
            if (!$this->passDeleteData($this->paramshandler->retreiveData())) {
                $this->redirectTo404();
            }
            $this->redirect("/topic/index?id={$currentThread}");
        }
        else {
            $this->redirectTo404();
        }
    }
}