<?php

namespace models;
use classes\SessionWrapper;
use classes\Topic;

use PDO;


class TopicModel extends Model {

    private function dataValid($postdata): bool {
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

    public function createArrayOfTopics($topics) {
        $topics_array = array();
        foreach($topics as $key => $topic) {
            $topics_array[] = new Topic($topic['name'], $topic['description'], $topic['user_id'], $topic['thread_id'], $topic['created']);
        }
        return $topics_array;
    }

    public function getAllTopics() {
        $statement = $this->db->prepare("SELECT * FROM topics");
        $statement->execute();
        $topics = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->createArrayOfTopics($topics);
    }

    public function getThreadTopics($thread_name) {
        $statement = $this->db->prepare("SELECT * FROM topics INNER JOIN threads ON topics.thread_id = threads.id WHERE threads.name=:thread_name");
        $statement->execute([':thread_name' => $thread_name]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopic($topic_id) {
        $statement = $this->db->prepare("SELECT * FROM topics WHERE id=:topic_id");
        $statement->execute([':topic_id' => $topic_id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    private function topicExsists($thread_name) {
        $statement = $this->db->prepare("SELECT id FROM topics WHERE name=:thread_name");
        $statement->execute([':thread_name' => $thread_name]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        }
        return false;
    }

    public function addNewTopic($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $thread = new Topic($params['name'], $params['description'], SessionWrapper::get('id'), time());
        $statement = $this->db->prepare('INSERT INTO topics (name, description, user_id) VALUES (:name, :description, :user_id)');
        $statement->execute([':name' => $thread->getName(), ':description' => $thread->getDescription(), ':user_id' => SessionWrapper::get('id')]);
    }

    public function editTopic($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $thread = new Topic($params['name'], $params['description'], );
        if (!$this->threadExsists($params['original_thread'])) {
            echo "404";
            die();
        }
        $statement = $this->db->prepare('UPDATE threads SET name=:name, description=:description WHERE name=:original_thread');
        $statement->execute([
            ':name' => $thread->getName(),
            ':description' => $thread->getDescription(),
            ':original_thread' => $params['original_thread']
        ]);
    }

    public function removeTopic($topic_id) {
        $statement = $this->db->prepare("DELETE FROM topics WHERE id=:topic_id");
        $statement->execute([':topic_id' => $topic_id]);
    }
}