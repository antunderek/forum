<?php

namespace classes;

class User {
    protected $username;
    protected $password;
    protected $email;
    protected $id;
    protected $administrator;

    public function __construct($email, $password, $username = null, $id = null) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getAdministrator()
    {
        return $this->administrator;
    }

    public function setAdministrator($administrator): void
    {
        $this->administrator = $administrator;
    }
}