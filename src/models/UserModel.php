<?php

namespace models;

use classes\User;

class UserModel extends Model {

    private function prepareRegisterData($postdata) {
        //object user
    }

    private function registerDataValid($postdata): bool {
        if (!isset($postdata)) {
            return false;
        }

        foreach ($postdata as $data) {
            echo trim($data);
            if (!isset($data) || empty(trim($data))) {
                return false;
            }
        }

        return true;
    }

    public function addUser($postdata) {
        var_dump($postdata);
        if (!$this->registerDataValid($postdata)) {
            return;
        }
        $postdata = $this->prepareRegisterData($postdata);
        var_dump($postdata);

        $statement = $this->db->prepare(
    "INSERT INTO users (username, password, email) VALUES (:user, :pass, :email)"
        );
        $statement->execute(
            array (
                ':user' => $postdata->getUser(),
                ':pass' => $postdata->getPassword(),
                ':email' => $postdata->getEmail(),
            )
        );
    }

    public function removeUser() {
    }

    public function changeUserData() {
    }

    /*
    public function getPost() {
        return (isset($_POST['user'], $_POST['pass']) || !in_array('', $_POST)) ? new User(trim($_POST['user']), trim($_POST['pass'])) : null;
    }
    */
}