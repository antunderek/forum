<?php

namespace controllers;

use classes\SessionWrapper;
use models\PostModel;
use views\PostView;

//Post controller saves and updates post data. After that returns the user back to the topic.

class PostController extends Controller {
    //Check if user can edit, create, remove posts
    public function edit() {
        if (!isset($_GET['id'])) {
            $topics = [];
        } else {
            $id = $_GET['id'];
            $post[] = $this->getPost($id);
        }
        $editview = new PostView();
        $editview->renderPage('editPost.php', $post);
        unset($_GET['id']);
    }

    public function getPost($id) {
        $model = new PostModel($this->db);
        return $model->getPost($id);
    }

    public function create() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('id') === $params['user_id']) {
            $model = new PostModel($this->db);
            $model->setPost($params);
            header("Location: /topic/posts?topic={$params['topic_id']}");
        }
        echo "Not allowed to make changes";
        die();
    }

    public function update() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('id') === $params['user']) {
            $model = new PostModel($this->db);
            $model->updatePost($params);
            header("Location: /topic/posts?topic={$params['topic']}");
        }
        else {
            var_dump($params, $_SESSION);
            var_dump(SessionWrapper::get('id') === $params['id']);
            echo "Not allowed to make changes";
            die();
        }
    }

    // Only removes content and ?name of the poster, leaves a message 'post deleted'
    public function delete() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator') || SessionWrapper::get('name') === $params['user']) {
            $model = new PostModel($this->db);
            $model->deletePost($params);
            header("Location: /topic/posts?topic={$params['topic']}");
        }
        else {
            echo "Not allowed to make changes";
            die();
        }
    }

    public function remove() {
        $params = $this->paramshandler->retreiveData();
        if (SessionWrapper::has('administrator')) {
            $model = new PostModel($this->db);
            $model->removePost($params);
            header("Location: /topic/posts?topic={$params['topic_id']}");
        }
        echo "Not allowed to make changes";
        die();
    }
}