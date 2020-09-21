<?php

namespace controllers;
use PDO;

use classes\SessionWrapper;
use classes\ParamsHandler;

use models\PostModel;

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
        if (!ParamsHandler::has('id')) {
            $this->redirectTo404();
        }
        $id = ParamsHandler::get('id');
        $post[] = $this->getPost($id);
        if (($post[0]->getUser() !== SessionWrapper::get('id')) && !SessionWrapper::has('administrator')) {
            $this->redirectTo404();
        }
        $editview = new PostView();
        $editview->renderPage('editPost', $post);
    }

    private function getPost($id) {
        $model = new PostModel($this->db);
        return $model->getPost($id);
    }

    public function create() {
        $this->checkIfUser();
        $params = $this->paramshandler->retreiveData();
        $model = new PostModel($this->db);
        $model->setPost($params);
        $this->redirect("/topic/posts?topic={$params['topic_id']}");
        $this->redirectTo404();
    }

    public function update() {
        if (SessionWrapper::has('administrator') || (SessionWrapper::get('id') === $params['user'])) {
            $params = $this->paramshandler->retreiveData();
            $model = new PostModel($this->db);
            $model->updatePost($params);
            $this->redirect("/topic/posts?topic={$params['topic']}");
        }
        $this->redirectTo404();
    }

    public function delete() {
        if (SessionWrapper::has('administrator') || (SessionWrapper::get('id') === $params['user'])) {
            $params = $this->paramshandler->retreiveData();
            $model = new PostModel($this->db);
            $model->deletePost($params);
            $this->redirect("/topic/posts?topic={$params['topic']}");
        }
        else {
            $this->redirectTo404();
        }
    }

    public function remove() {
        if (SessionWrapper::has('administrator')) {
            $params = $this->paramshandler->retreiveData();
            $model = new PostModel($this->db);
            $model->removePost($params);
            $this->redirect("/topic/posts?topic={$params['topic_id']}");
        }
        $this->redirectTo404();
    }
}