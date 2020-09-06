<?php

namespace models;
use PDO;

use classes\ForumThread;

class ThreadModel extends Model {

    private function createArrayOfObjects($threads, $thread_name = null) {
        $threadArray = array();
        foreach($threads as $key => $thread) {
            $threadArray[] = new ForumThread($thread['name'], $thread['description'], $thread_name);
        }
        return $threadArray;
    }

    // reformatirati, razdvojiti funkcije i promjeniti nazive
    public function getAllData($type = THREAD, $thread_id = null) {
        $query = [
            THREAD => "SELECT name, description FROM threads",
            SUBTHREAD => "SELECT subthreads.name, subthreads.description FROM subthreads INNER JOIN threads ON subthreads.thread_id=subthreads.id WHERE threads.name=:threadname",
        ];
        $statement = $this->db->prepare($query[$type]);
        $type === THREAD ? $statement->execute() : $statement->execute([':threadname' => $thread_id]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $data = $statement->fetchAll();
        $data= $this->createArrayOfObjects($data, $thread_id);
        return $data;
    }

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
}