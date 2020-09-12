<?php

namespace models;
use PDO;

use classes\User;
use classes\SessionWrapper;

class UserModel extends Model {

    private function dataValid($postdata) {
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
        return new User(trim($data['email']), $password, $username, $id, $data['image']);
    }

    private function createArrayOfUsers($users) {
        $usersArray = array();
        foreach($users as $key => $user) {
            $usersArray[] = new User($user['email'], null, $user['username'], $user['id'], $user['image']);
        }
        return $usersArray;
    }

    private function checkIfAdmin($user_id) {
        $statement = $this->db->prepare("SELECT administrators.user_id FROM administrators INNER JOIN users ON administrators.user_id = users.id WHERE administrators.user_id = :user_id");
        $statement->execute([':user_id' => $user_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    private function checkIfUsernameTaken(string $username) {
        $statement = $this->db->prepare("SELECT username FROM users WHERE username=:username");
        $statement->execute([':username' => $username]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    private function checkIfEmailTaken(string $email)
    {
        $statement = $this->db->prepare("SELECT email FROM users WHERE email=:email");
        $statement->execute([':email' => $email]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addUser($postdata) {
        if (!$this->dataValid($postdata)) {
            $this->tempStoreUserInput($postdata);
            SessionWrapper::set('register_error', 'Please input data in all fields.');
            return;
        }
        if ($this->checkIfUsernameTaken($postdata['username'])) {
            SessionWrapper::set('register_error', 'Name already taken');
        }
        if ($this->checkIfEmailTaken($postdata['email'])) {
            if (SessionWrapper::has('register_error')) {
                SessionWrapper::set('register_error', 'Name and email already taken');
            }
            else {
                SessionWrapper::set('register_error', 'Email already taken');
            }
        }
        if (SessionWrapper::has('register_error')) {
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

        $user = $this->getUserByEmail($postdata['email']);
        $addSessionStatement = $this->db->prepare(
            "INSERT INTO sessions (id) VALUES (:id)"
        );
        $addSessionStatement->execute(
            array (
                ':id' => $user->getId(),
            )
        );

    }

    public function getUsers() {
        $statement = $this->db->prepare("SELECT * FROM users");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = $this->createArrayOfUsers($result);
        foreach ($users as $key => $user) {
            if ($this->checkIfAdmin($user->getId())) {
                $user->setAdministrator(true);
            }
        }
        return $users;
    }

    public function getUserById(int $id, $password = false) {
        $statement = $this->db->prepare(
            "SELECT users.email, passwords.password, users.username, users.id, users.image FROM users INNER JOIN passwords ON users.id = passwords.user_id WHERE users.id=:id;"
        );
        if (!$password) {
            $statement = $this->db->prepare(
        "SELECT users.email, users.username, users.id, users.image FROM users WHERE users.id=:id;"
            );
        }
        $statement->execute(
            [
                ':id' => $id
            ]
        );
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$password) {
            $result['password'] = null;
        }
        $user = $this->createUser($result);
        if ($this->checkIfAdmin($user->getId())) {
            $user->setAdministrator(true);
        }
        return $user;
    }

    private function getUserByEmail(string $email) {
        $statement = $this->db->prepare(
            "SELECT users.email, passwords.password, users.username, users.id, users.image FROM users INNER JOIN passwords ON users.id = passwords.user_id WHERE users.email=:email;"
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
        $dbuser = $this->getUserByEmail($userdata->getEmail());
        if (!isset($dbuser) || !password_verify($userdata->getPassword(), $dbuser->getPassword())) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('login_error', 'Wrong email or password');
            return;
        }
        SessionWrapper::set('name', $dbuser->getUsername());
        SessionWrapper::set('id', $dbuser->getId());
        if ($dbuser->getAdministrator()) {
            SessionWrapper::set('administrator', true);
        }
        $this->setSession();
    }

    public function addAdministrator($id) {
        $statement = $this->db->prepare("INSERT INTO administrators (user_id) VALUES (:user_id)");
        $statement->execute([
            ':user_id' => $id,
        ]);
    }

    public function removeAdministrator($id) {
        $statement = $this->db->prepare("DELETE FROM administrators WHERE user_id=:user_id");
        $statement->execute([
            ':user_id' => $id,
        ]);
    }

    public function updateUsernameEmail($id, $params) {
        if (!$this->dataValid($params)) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('update_error', 'Please input data in all fields.');
            return;
        }
        $user = $this->getUserById($id);
        if (!isset($user)) {
            echo "User doesn't exist";
            die();
        }
        $user->setUsername($params['username']);
        $user->setEmail($params['email']);
        $statement = $this->db->prepare("UPDATE users SET username=:username, email=:email WHERE id=:id");
        $statement->execute([':username' => $user->getUsername(), ':email' => $user->getEmail(), ':id' => $id]);
        SessionWrapper::set('name', $user->getUsername());
    }

    public function changePassword($id, $params) {
        if (!$this->dataValid($params)) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('password_error', 'Please input data in all fields.');
            return;
        }
        $dbUser = $this->getUserById($id, true);
        if (!isset($dbUser) || !password_verify(trim($params['current-password']), $dbUser->getPassword())) {
            $this->tempStoreUserInput($params);
            SessionWrapper::set('password_error', 'Password incorrect');
            return;
        }
        if (trim($params['new-password']) !== trim($params['check-password'])) {
            SessionWrapper::set('password_error', "Passwords don't match");
            return;
        }
        $password = password_hash(trim($params['new-password']), PASSWORD_ARGON2ID);
        $statement = $this->db->prepare("UPDATE passwords SET password=:password WHERE user_id=:id");
        $statement->execute([
            ':password' => $password,
            ':id' => $id,
        ]);
    }

    public function removeUser($id) {
       $statement = $this->db->prepare('DELETE FROM users WHERE id=:id');
       $statement->execute([':id' => $id]);
    }

    public function changeProfilePicture($id, $image) {
       $statement = $this->db->prepare("UPDATE users SET image=:image WHERE id=:id");
       $statement->execute([':image' => $image, ':id' => $id]);
    }

    public function setSession() {
        $statement = $this->db->prepare("UPDATE sessions SET session_id=:session_id WHERE id=:id");
        $statement->execute([
            ':session_id' => session_id(),
            ':id' => SessionWrapper::get('id')
        ]);
    }

    public function getSession() {
        $statement = $this->db->prepare("SELECT * FROM sessions WHERE id=:id");
        $statement->execute([
            ':id' => SessionWrapper::get('id')
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function sessionValid() {
        $lastSession = $this->getSession();
        $currentSession = session_id();
        if ($currentSession !== $lastSession['session_id']) {
            return false;
        }
        return true;
    }

    public function sessionNotValid()
    {
        SessionWrapper::destroy();
        session_start();
        SessionWrapper::set('notification', 'You have been logged out.');
        header("Refresh:0");
    }

    public function doSessionCheck() {
        if(!$this->sessionValid()) {
            $this->sessionNotValid();
        }
    }
}