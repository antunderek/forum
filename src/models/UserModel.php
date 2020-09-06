<?php

namespace models;

use classes\User;
use classes\SessionWrapper;
use MongoDB\Driver\Session;
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

    private function tempStoreUserInput($postdata) {
        $temp_data = null;
        foreach ($postdata as $key => $data) {
            if (isset($data) && $key !== 'password') {
                $temp_data[$key] = $data;
            }
        }
        if (isset($temp_data)) {
            SessionWrapper::set('temp_data', $temp_data);
        }
    }

    private function createUser($data, $newuser = false) {
        $username = isset($data['username']) ? trim($data['username']) : null;
        $id = isset($data['id']) ? $data['id'] : null;
        $password = $newuser ? password_hash(trim($data['password']), PASSWORD_ARGON2ID) : trim($data['password']);
        return new User(trim($data['email']), $password, $username, $id);
    }

    private function checkIfAdmin($user_id) {
        $statement = $this->db->prepare("SELECT administrators.user_id FROM administrators INNER JOIN users ON administrators.user_id = users.id WHERE administrators.user_id = :user_id");
        $statement->execute([':user_id' => $user_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    private function checkIfUsernameTaken() {
    }

    private function checkIfEmailTaken() {
    }

    public function addUser($postdata) {
        if (!$this->dataValid($postdata)) {
            $this->tempStoreUserInput($postdata);
            SessionWrapper::set('register_error', 'Please input data in all fields.');
            return;
        }
        $this->checkIfUsernameTaken();
        $this->checkIfEmailTaken();
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
            "SELECT users.email, passwords.password, users.username, users.id FROM users INNER JOIN passwords ON users.id = passwords.user_id WHERE users.email=:email;"
        );
        $statement->execute(
            [
                ':email' => $email
            ]
        );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $user = $this->createUser($result);
        if ($this->checkIfAdmin($user->getId())) {
            $user->setAdministrator(true);
        }
        return $user;
    }

    public function loginUser($params) {
        if (!$this->dataValid($params)) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('login_error', 'Please input data in all fields.');
            return;
        }
        $userdata = $this->createUser($params);
        $dbuser = $this->findUserByEmail($userdata->getEmail());
        if (!isset($dbuser) || !password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('login_error', 'Wrong email or password');
        }
        if (password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            SessionWrapper::set('name', $dbuser->getUsername());
            SessionWrapper::set('id', $dbuser->getId());
            if ($dbuser->getAdministrator()) {
                SessionWrapper::set('administrator', true);
            }
        }
    }

    public function addAdministrator() {
    }

    public function removeAdministrator() {
    }

    public function removeUser() {
    }

    public function changeUserData() {
    }
}