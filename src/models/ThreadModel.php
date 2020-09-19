<?php

namespace models;
use PDO;

use classes\SessionWrapper;
use classes\ForumThread;

class ThreadModel extends Model {

    private function dataValid($postdata): bool {
        if (!isset($postdata) || empty($postdata)) {
            return false;
        }
        if (!isset($postdata['name']) || empty(trim($postdata['name']))) {
            return false;
        }
        return true;
    }

    private function createArrayOfThreads($threads) {
        $threadArray = array();
        foreach($threads as $key => $thread) {
            $threadArray[] = new ForumThread($thread['name'], $thread['description'], $thread['id']);
        }
        return $threadArray;
    }

    public function getAllThreads() {
        $statement = $this->db->prepare("SELECT * FROM threads");
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $data= $this->createArrayOfThreads($data);
        return $data;
    }

    public function getThread($id) {
        $statement = $this->db->prepare("SELECT * FROM threads WHERE id=:id");
        $statement->execute([
            ':id' => $id
        ]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        if (!$result) {
            return false;
        }
        //$data[] = new ForumThread($result['name'], $result['description'], $result['id']);
        $data = new ForumThread($result['name'], $result['description'], $result['id']);
        return $data;
    }

    private function threadNameExsists($thread_name) {
        $statement = $this->db->prepare("SELECT id FROM threads WHERE name=:thread_name");
        $statement->execute([':thread_name' => $thread_name]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? true : false;
    }

    private function threadExsists($thread_id) {
        $statement = $this->db->prepare("SELECT id FROM threads WHERE id=:id");
        $statement->execute([':id' => $thread_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? true : false;
    }

    public function addNewThread($params) {
        if (!$this->dataValid($params)) {
            SessionWrapper::set('notification', 'Thread name is not set.');
            return false;
        }
        if ($this->threadNameExsists($params['name'])) {
            SessionWrapper::set('notification', 'Thread already exists.');
            return false;
        }
        $thread = new ForumThread($params['name'], $params['description']);
        $statement = $this->db->prepare('INSERT INTO threads (name, description) VALUES (:name, :description)');
        $statement->execute([':name' => $thread->getName(), ':description' => $thread->getDescription()]);
        return true;
    }

    public function editThread($params) {
        if (!$this->dataValid($params)) {
            SessionWrapper::set('notification', 'Thread name is not set.');
            return false;
        }
        if (!$this->threadExsists($params['original_thread'])) {
            $this->redirectTo404();
        }
        $thread = new ForumThread($params['name'], $params['description']);
        $statement = $this->db->prepare('UPDATE threads SET name=:name, description=:description WHERE name=:original_thread');
        $statement->execute([
            ':name' => $thread->getName(),
            ':description' => $thread->getDescription(),
            ':original_thread' => $params['original_thread']
        ]);
    }

    public function removeThread($id) {
        if (!$this->threadExsists($id)) {
            $this->redirectTo404();
        }
        $statement = $this->db->prepare("DELETE FROM threads WHERE id=:id");
        $statement->execute([':id' => $id]);
    }
}