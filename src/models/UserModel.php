<?php

namespace models;

use classes\User;
use classes\SessionWrapper;
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
            SessionWrapper::set('register_error', 'Please input data in all fields.');
            return;
        }
        $userdata = $this->createUser($postdata, true);
        $addUserStatement = $this->db->prepare(
            "INSERT INTO users (email, username) VALUES (:email, :username)"
        );
        $addPasswordStatement = $this->db->prepare(
            "INSERT INTO passwords (password, user_id) VALUES (:password, (SELECT id FROM users WHERE username=:username))"
        );

        $addUserStatement->execute(
            array (
                ':username' => $userdata->getUsername(),
                ':email' => $userdata->getEmail(),
            )
        );

        $addPasswordStatement->execute(
            array (
                ':username' => $userdata->getUsername(),
                ':password' => $userdata->getPassword(),
            )
        );

    }

    private function findUserByEmail(string $email) {
        $statement = $this->db->prepare(
            "SELECT users.email, passwords.password, users.username FROM users INNER JOIN passwords ON users.id = passwords.user_id WHERE users.email=:email;"
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
            SessionWrapper::set('login_error', 'Please input data in all fields.');
            return;
        }
        $userdata = $this->createUser($params);
        $dbuser = $this->findUserByEmail($userdata->getEmail());
        if (!isset($dbuser) || !password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            echo 'wrong password or username';
            SessionWrapper::set('login_error', 'Wrong email or password');
        }
        if (password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            SessionWrapper::set('name', $dbuser->getUsername());
        }
    }

    public function removeUser() {
    }

    public function changeUserData() {
    }
}