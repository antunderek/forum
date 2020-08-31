<?php

namespace models;

use classes\User;

class HomeModel extends Model {

    public function addData($postdata) {
        if (!isset($postdata)) {
            return;
        }
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

    public function getPost() {
        return (isset($_POST['user'], $_POST['pass']) || !in_array('', $_POST)) ? new User(trim($_POST['user']), trim($_POST['pass'])) : null;
    }
}