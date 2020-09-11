<?php

namespace controllers;

use classes\SessionWrapper;
use models\PostModel;
use PDO;
use views\PostView;

class PostController extends Controller {
    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->checkIfUser();
    }

    private function checkIfUser() {
        if (!SessionWrapper::has('id')) {
            $this->redirectTo404();
        }
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $topics = [];
        } else {
            $id = $_GET['id'];
            $post[] = $this->getPost($id);
            if ($post[0]->getUser() !== SessionWrapper::get('id') && !SessionWrapper::has('administrator')) {
                $this->redirectTo404();
            }
        }
        $editview = new PostView();
        $editview->renderPage('editPost', $post);
        unset($_GET['id']);
    }

    private function getPost($id) {
        $model = new PostModel($this->db);
        return $model->getPost($id);
    }

    public function create() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('id') === $params['user_id']) {
            $model = new PostModel($this->db);
            $model->setPost($params);
            $this->redirect("/topic/posts?topic={$params['topic_id']}");
        }
        $this->redirectTo404();
    }

    public function update() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('id') === $params['user']) {
            $model = new PostModel($this->db);
            $model->updatePost($params);
            $this->redirect("/topic/posts?topic={$params['topic']}");
        }
        $this->redirectTo404();
    }

    public function delete() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('name') === $params['user']) {
            $model = new PostModel($this->db);
            $model->deletePost($params);
            $this->redirect("/topic/posts?topic={$params['topic']}");
        }
        else {
            $this->redirectTo404();
        }
    }

    public function remove() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator')) {
            $model = new PostModel($this->db);
            $model->removePost($params);
            $this->redirect("/topic/posts?topic={$params['topic_id']}");
        }
        $this->redirectTo404();
    }
}