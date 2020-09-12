<?php

namespace models;
use classes\SessionWrapper;
use MongoDB\Driver\Session;
use PDO;

use classes\ForumThread;

class ThreadModel extends Model {

    private function dataValid($postdata): bool {
        if (!isset($postdata) || empty($postdata)) {
            return false;
        }
        if (!isset($postdata['name']) || empty(trim($postdata['name']))) {
            var_dump(!isset($postdata['name']));
            var_dump(empty(trim($postdata['name'])));
            return false;
        }
        return true;
    }

    private function createArrayOfThreads($threads) {
        $threadArray = array();
        foreach($threads as $key => $thread) {
            $threadArray[] = new ForumThread($thread['name'], $thread['description']);
        }
        return $threadArray;
    }

    public function getAllThreads() {
        $statement = $this->db->prepare("SELECT name, description FROM threads");
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $data= $this->createArrayOfThreads($data);
        return $data;
    }

    public function getThread($name) {
        $statement = $this->db->prepare("SELECT name, description FROM threads WHERE name=:name");
        $statement->execute([
            ':name' => $name
        ]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $data[] = new ForumThread($result['name'], $result['description']);
        return $data;
    }

    private function threadExsists($thread_name) {
        $statement = $this->db->prepare("SELECT id FROM threads WHERE name=:thread_name");
        $statement->execute([':thread_name' => $thread_name]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        }
        return false;
    }

    public function addNewThread($params) {
        if (!$this->dataValid($params)) {
            SessionWrapper::set('notification', 'Thread name is not set.');
            return;
        }
        $thread = new ForumThread($params['name'], $params['description']);
        if ($this->threadExsists($thread->getName())) {
            SessionWrapper::set('notification', 'Thread already exists.');
            return;
        }
        $statement = $this->db->prepare('INSERT INTO threads (name, description) VALUES (:name, :description)');
        $statement->execute([':name' => $thread->getName(), ':description' => $thread->getDescription()]);
        return;
    }

    public function editThread($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $thread = new ForumThread($params['name'], $params['description']);
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

    public function removeThread($name) {
        $statement = $this->db->prepare("DELETE FROM threads WHERE name=:thread_name");
        $statement->execute([':thread_name' => $name]);
    }
}