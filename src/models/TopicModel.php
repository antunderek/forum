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
        foreach ($postdata as $key => $data) {
            if (!isset($data) || empty(trim($data))) {
                if ($key === 'description') {
                    continue;
                }
                return false;
            }
        }
        return true;
    }

    public function createArrayOfTopics($topics) {
        $topics_array = array();
        foreach($topics as $key => $topic) {
            $topics_array[] = new Topic($topic['name'], $topic['description'], $topic['user_id'], $topic['thread_id'], $topic['id'], $topic['created']);
        }
        return $topics_array;
    }

    public function getAllTopics() {
        $statement = $this->db->prepare("SELECT * FROM topics");
        $statement->execute();
        $topics_array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->createArrayOfTopics($topics_array);
    }

    public function getThreadTopics($threadName) {
        $statement = $this->db->prepare("
            SELECT topics.name, topics.description, users.username AS user_id, topics.thread_id, topics.id, topics.created 
            FROM topics
            INNER JOIN threads ON topics.thread_id = threads.id 
            INNER JOIN users ON topics.user_id = users.id
            WHERE threads.name=:thread_name
        ");
        $statement->execute([':thread_name' => $threadName]);
        $topicsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->createArrayOfTopics($topicsArray);
    }

    public function getTopic($topicId) {
        $statement = $this->db->prepare("
            SELECT topics.name, topics.description, topics.user_id, topics.thread_id, topics.id, topics.created 
            FROM topics
            WHERE topics.id=:topicId
        ");
        $statement->execute([':topicId' => $topicId]);
        $topicArray = $statement->fetch(PDO::FETCH_ASSOC);
        return new Topic($topicArray['name'], $topicArray['description'], $topicArray['user_id'], $topicArray['thread_id'], $topicArray['id'], $topicArray['created']);
    }


    private function topicExsists($topicId) {
        $statement = $this->db->prepare("SELECT * FROM topics WHERE id=:topic_id");
        $topicId = (int)$topicId;
        $statement->execute([':topic_id' => $topicId]);
        $topicArray = $statement->fetch(PDO::FETCH_ASSOC);
        return new Topic($topicArray['name'], $topicArray['description'], $topicArray['user_id'], $topicArray['thread_id'], $topicArray['id'], $topicArray['created']);
    }

    public function addNewTopic($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $thread = new Topic($params['name'], $params['description'], SessionWrapper::get('id'), $params['current_thread']);
        $statement = $this->db->prepare('INSERT INTO topics (name, description, user_id, thread_id) VALUES (:name, :description, :user_id, (SELECT id FROM threads WHERE name=:thread_id ))');
        $statement->execute([':name' => $thread->getName(), ':description' => $thread->getDescription(), ':user_id' => SessionWrapper::get('id'), ':thread_id' => $thread->getParent()]);
    }

    public function editTopic($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $topic = $this->topicExsists($params['id']);
        if (!$topic) {
            header('Location: /pagenotfound');
            exit;
        }
        if (($topic->getTopicCreator() !== SessionWrapper::get('id')) && !SessionWrapper::has('administrator')) {
            return false;
        }
        $topic->setName($params['name']);
        $topic->setDescription($params['description']);
        $statement = $this->db->prepare('UPDATE topics SET name=:name, description=:description WHERE id=:topic_id');
        $statement->execute([
            ':name' => $topic->getName(),
            ':description' => $topic->getDescription(),
            ':topic_id' => $params['id']
        ]);
        return true;
    }

    public function removeTopic($topic_id) {
        $topic = $this->getTopic($topic_id);
        if (($topic->getTopicCreator() !== SessionWrapper::get('name')) && !SessionWrapper::get('administrator')) {
            return false;
        }
        $statement = $this->db->prepare("DELETE FROM topics WHERE id=:topic_id");
        $statement->execute([':topic_id' => $topic_id]);
        return true;
    }
}