<?php

namespace models;
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

    private function createArrayOfThreadsOrSubthreads($threads, $thread_name = null) {
        $threadArray = array();
        foreach($threads as $key => $thread) {
            $threadArray[] = new ForumThread($thread['name'], $thread['description'], $thread_name);
        }
        return $threadArray;
    }

    public function getAllThreadsOrSubthreads($type) {
        $query = [
            THREAD => "SELECT name, description FROM threads",
            SUBTHREAD => "SELECT name, description FROM subthreads",
        ];
        $statement = $this->db->prepare($query[$type]);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $data= $this->createArrayOfThreadsOrSubthreads($data);
        return $data;
    }

    public function getThreadsSubthreads($thread_id) {
        $statement = $this->db->prepare("SELECT subthreads.name, subthreads.description FROM subthreads INNER JOIN threads ON subthreads.thread_id = threads.id WHERE threads.name = :thread_id");
        $statement->execute([':thread_id' => $thread_id]);
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->createArrayOfThreadsOrSubthreads($data, $thread_id);
        return $data;
    }

    // Reformatirati, razdvojiti promjeniti nazive
    public function getData($name, $type = THREAD, $thread_name = null) {
        $query = [
            THREAD => "SELECT name, description FROM threads WHERE name=:name",
            SUBTHREAD => "SELECT subthreads.name, subthreads.description FROM subthreads 
                          INNER JOIN threads ON subthreads.thread_id=threads.id 
                          WHERE threads.name=:thread_name AND subthreads.name=:name"
        ];
        $statement = $this->db->prepare($query[$type]);
        if ($type === THREAD) {
            $statement->execute([
                ':name' => $name
            ]);
        } else {
            $statement->execute([
                ':name' => $name,
                ':thread_name' => $thread_name
            ]);
        }
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $data[] = new ForumThread($result['name'], $result['description'], $thread_name);
        return $data;
    }

    private function threadExsists($thread_name) {
        $statement = $this->db->prepare("SELECT id FROM threads WHERE name=:thread_name");
        $statement->execute([':thread_name' => $thread_name]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (!isset($result)) {
            return false;
        }
        return true;
    }

    public function addNewThread($params) {
        if (!$this->dataValid($params)) {
            echo 'Name is empty';
            die();
        }
        $thread = new ForumThread($params['name'], $params['description']);
        if ($this->threadExsists($thread->getName())) {
            echo 'Thread already exists';
            die();
        }
        $statement = $this->db->prepare('INSERT INTO threads (name, description) VALUES (:name, :description)');
        $statement->execute([':name' => $thread->getName(), ':description' => $thread->getDescription()]);
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