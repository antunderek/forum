<?php

class HomeModel {
    protected $db;
    //protected $postdata;

    public function __construct(PDO $db) {
        $this->db = $db;
        //$this->postdata = $postdata;
    }

    public function addData($postdata) {
        $statement = $this->db->prepare(
    "INSERT INTO users (username, password) VALUES (:user, :pass)"
        );
        $statement->execute(
            array (
                ':user' => $postdata->getUser(),
                ':pass' => $postdata->getPassword()
            )
        );
    }
}