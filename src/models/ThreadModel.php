<?php

namespace models;
use PDO;

use classes\ForumThread;

class ThreadModel extends Model {

    private function createThreadArray($threads) {
        $threadArray = array();
        foreach($threads as $key => $thread) {
            $threadArray[] = new ForumThread($thread['name'], $thread['description']);
        }
        return $threadArray;
    }

    public function getThreads() {
        $retriveThreadsStatement = $this->db->prepare(
            "SELECT name, description FROM threads"
        );
        $retriveThreadsStatement->execute();
        $retriveThreadsStatement->setFetchMode(PDO::FETCH_ASSOC);
        $threads = $retriveThreadsStatement->fetchAll();
        $threads = $this->createThreadArray($threads);
        return $threads;
    }

    public function getSubthreads($threadid) {}

    public function getTopics($subthreadid) {}

    public function getData($type = THREAD) {
        $query = null;
        switch($type) {
            case THREAD:
                $query = "SELECT name, description FROM threads";
                break;
            case SUBTHREAD:
                $query = "SELECT threads.name, threads.description FROM threads INNER JOIN subthreads ON threads.id=subthreads.threads_id WHERE threads.name=:threadname";
                break;
            case TOPIC:
                $query = "SELECT topics.name, topics.description, topics.FROM threads INNER JOIN topics ON subthreads.id=topics.";
                break;
            default:
                $type = null;
        }
        var_dump($query);
    }
}