<?php

namespace models;
use PDO;

use classes\SessionWrapper;
use classes\Post;

class PostModel extends Model {

    private function dataValid($postdata) {
        if (!isset($postdata) || empty($postdata)) {
            return false;
        }
        foreach ($postdata as $data) {
            if (!isset($data) || empty(trim($data))) {
                return false;
            }
        }
        return true;
    }

    private function objectPostArray($posts) {
        $postsArray = array();
        foreach($posts as $post) {
            $postsArray[] = new Post($post['topic_id'], $post['user_id'], $post['content'], $post['id'], $post['dateposted']);
        }
        return $postsArray;
    }

    public function getPosts($topicId) {
        $statement = $this->db->prepare(
            "SELECT posts.topic_id, posts.user_id , posts.content, posts.id, posts.dateposted FROM posts 
                      WHERE posts.topic_id = :topicId ORDER BY posts.dateposted ASC"
        );
        $statement->execute([':topicId' => $topicId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->objectPostArray($result);
    }

    public function getPost($postId) {
        $statement = $this->db->prepare("SELECT * FROM posts WHERE id=:postId");
        $statement->execute([':postId' => $postId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return new Post($result['topic_id'], $result['user_id'], $result['content'], $result['id'], $result['dateposted']);
    }

    public function setPost($params) {
        if (!$this->dataValid($params)) {
            $this->redirectTo404();
        }
        $post = new Post($params['topic_id'], $params['user_id'], $params['content']);
        $statement = $this->db->prepare("INSERT INTO posts(topic_id, user_id, content) VALUES (:topicId, :userId, :content)");
        $statement->execute([
            ':topicId' => $post->getTopic(),
            ':userId' => $post->getUser(),
            ':content' => $post->getContent(),
        ]);
        return $post;
    }

    public function updatePost($params) {
        if (!$this->dataValid($params)) {
            $this->redirectTo404();
        }
        $post = $this->getPost($params['id']);
        if (!$post) {
            $this->redirectTo404();
        }
        if ($post->getUser() !== $params['user'] && !SessionWrapper::has('administrator')) {
            $this->redirectTo404();
        }
        $post->setContent($params['content']);
        $statement = $this->db->prepare("UPDATE posts SET content=:content WHERE id=:postId");
        $statement->execute([
            ':content' => $post->getContent(),
            ':postId' => $post->getId(),
        ]);
    }

    public function deletePost($params) {
        if (!$this->dataValid($params)) {
            $this->redirectTo404();
        }
        $post = $this->getPost($params['id']);
        if (!$post) {
            $this->redirectTo404();
        }
        if (!SessionWrapper::has('administrator') && $post->getUser() !== SessionWrapper::get('id')) {
            $this->redirectTo404();
        }
        $post->setContent('Post has been deleted.');
        $statement = $this->db->prepare("UPDATE posts SET content=:content WHERE id=:postId");
        $statement->execute([
            ':content' => $post->getContent(),
            ':postId' => $post->getId(),
        ]);
    }

    public function removePost($params) {
        if (!$this->dataValid($params)) {
            $this->redirectTo404();
        }
        $post = $this->getPost($params['id']);
        if (!$post) {
            $this->redirectTo404();
        }
        $statement = $this->db->prepare("DELETE FROM posts WHERE id=:postId");
        $statement->execute([
            ':postId' => $post->getId(),
        ]);
    }
}