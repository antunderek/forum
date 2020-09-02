<?php

namespace models;

//use Cassandra\Statement;
use classes\User;
use PDO;

class UserModel extends Model {

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

    private function createUser($postdata, $newuser = false) {
        $username = isset($postdata['username']) ? trim($postdata['username']) : null;
        $password = $newuser ? password_hash(trim($postdata['password']), PASSWORD_ARGON2ID) : trim($postdata['password']);
        return new User(trim($postdata['email']), $password, $username);
    }

    public function addUser($postdata) {
        if (!$this->dataValid($postdata)) {
            return;
        }
        $userdata = $this->createUser($postdata, true);
        $statement = $this->db->prepare(
    "INSERT INTO users (email, password, username) VALUES (:email, :password, :username)"
        );
        $statement->execute(
            array (
                ':username' => $userdata->getUsername(),
                ':password' => $userdata->getPassword(),
                ':email' => $userdata->getEmail(),
            )
        );
    }

    private function findUserByEmail(string $email) {
        $statement = $this->db->prepare(
            'SELECT email, password, username FROM users WHERE email=:email'
        );
        $statement->execute(
            [
                ':email' => $email
            ]
        );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $user = $this->createUser($result);

        return $user;
    }

    public function loginUser($params) {
        if (!$this->dataValid($params)) {
            return;
        }
        $userdata = $this->createUser($params);
        $dbuser = $this->findUserByEmail($userdata->getEmail());
        if (!$dbuser) {
            echo 'wrong password or username';
            return;
        }
        if (password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            $_SESSION['name'] = $dbuser->getUsername();
        }
    }

    public function removeUser() {
    }

    public function changeUserData() {
    }
}