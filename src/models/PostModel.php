<?php

namespace models;
use PDO;
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
            "SELECT posts.topic_id, users.username AS user_id , posts.content, posts.id, posts.dateposted FROM posts 
                      INNER JOIN users ON posts.user_id=users.id 
                      WHERE topic_id = :topicId"
        );
        $statement->execute([':topicId' => $topicId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->objectPostArray($result);
    }

    public function setPost($params) {
        if (!$this->dataValid($params)) {
            echo "here goes 404";
            die();
        }
        $post = new Post($params['topic_id'], $params['user_id'], $params['content']);
        $statement = $this->db->prepare("INSERT INTO posts(topic_id, user_id, content) VALUES (:topicId, :userId, :content)");
        $statement->execute([
            ':topicId' => $post->getTopicId(),
            ':userId' => $post->getUser(),
            ':content' => $post->getContent(),
        ]);
        return $post;
    }

}