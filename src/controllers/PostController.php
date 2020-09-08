<?php

namespace controllers;

use classes\SessionWrapper;
use models\PostModel;

//Post controller saves and updates post data. After that returns the user back to the topic.

class PostController extends Controller {
    //Check if user can edit, create, remove posts

    public function create() {
        $params = $this->paramshandler->retreiveData();
        if (!SessionWrapper::has('administrator') || SessionWrapper::get('id') !== $params['user_id']) {
            echo "Not allowed to make changes";
            die();
        }
        $model = new PostModel($this->db);
        $model->setPost($params);
        header("Location: /topic/posts?topic={$params['topic_id']}");
    }

    // Post sadrzi varijable
    public function editPost($postId, $data) {}

    // Only removes content and ?name of the poster, leaves a message 'post deleted'
    public function removePost($postId) {}
}